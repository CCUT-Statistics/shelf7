<?php
/**
 * pan123_storage queue worker
 *
 * Usage:
 *   php plugin/pan123_storage/cli/worker.php --limit=20
 *   php plugin/pan123_storage/cli/worker.php --loop --sleep=2 --limit=20
 */

if (PHP_SAPI !== 'cli') {
    exit("CLI only.\n");
}

!defined('DEBUG') AND define('DEBUG', 0);
!defined('APP_PATH') AND define('APP_PATH', dirname(dirname(dirname(__DIR__))) . '/');
!defined('XIUNOPHP_PATH') AND define('XIUNOPHP_PATH', APP_PATH . 'xiunophp/');

$conf = (@include APP_PATH . 'conf/conf.php');
if (empty($conf) || !is_array($conf)) {
    fwrite(STDERR, "[pan123_worker] conf/conf.php not found. Run worker on installed site.\n");
    exit(2);
}

// align with index.php path normalization
isset($conf['log_path']) AND substr($conf['log_path'], 0, 2) == './' AND $conf['log_path'] = APP_PATH . $conf['log_path'];
isset($conf['tmp_path']) AND substr($conf['tmp_path'], 0, 2) == './' AND $conf['tmp_path'] = APP_PATH . $conf['tmp_path'];
isset($conf['upload_path']) AND substr($conf['upload_path'], 0, 2) == './' AND $conf['upload_path'] = APP_PATH . $conf['upload_path'];
$_SERVER['conf'] = $conf;

include XIUNOPHP_PATH . 'xiunophp.min.php';
include APP_PATH . 'model/plugin.func.php';
include _include(APP_PATH . 'model.inc.php');
include _include(APP_PATH . 'plugin/pan123_storage/model/pan123.func.php');

function pan123_worker_read_options($argv) {
    $opt = array(
        'limit' => 10,
        'loop' => 0,
        'sleep' => 2,
        'max_loops' => 0,
    );
    $argc = count($argv);
    for ($i = 1; $i < $argc; $i++) {
        $arg = strval($argv[$i]);
        if (strpos($arg, '--limit=') === 0) {
            $opt['limit'] = intval(substr($arg, 8));
            continue;
        }
        if ($arg === '--limit' && isset($argv[$i + 1])) {
            $opt['limit'] = intval($argv[$i + 1]);
            $i++;
            continue;
        }
        if ($arg === '--loop') {
            $opt['loop'] = 1;
            continue;
        }
        if (strpos($arg, '--sleep=') === 0) {
            $opt['sleep'] = intval(substr($arg, 8));
            continue;
        }
        if ($arg === '--sleep' && isset($argv[$i + 1])) {
            $opt['sleep'] = intval($argv[$i + 1]);
            $i++;
            continue;
        }
        if (strpos($arg, '--max-loops=') === 0) {
            $opt['max_loops'] = intval(substr($arg, 12));
            continue;
        }
        if ($arg === '--max-loops' && isset($argv[$i + 1])) {
            $opt['max_loops'] = intval($argv[$i + 1]);
            $i++;
            continue;
        }
    }
    if ($opt['limit'] < 1) $opt['limit'] = 1;
    if ($opt['limit'] > 200) $opt['limit'] = 200;
    if ($opt['sleep'] < 1) $opt['sleep'] = 1;
    if ($opt['sleep'] > 60) $opt['sleep'] = 60;
    if ($opt['max_loops'] < 0) $opt['max_loops'] = 0;
    return $opt;
}

function pan123_worker_lock_file() {
    global $conf;
    $upload_path = !empty($conf['upload_path']) ? strval($conf['upload_path']) : APP_PATH . 'upload/';
    $dir = rtrim($upload_path, '/\\') . '/log/';
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
    return $dir . 'pan123_worker.lock';
}

function pan123_worker_try_lock($lock_file) {
    $fp = @fopen($lock_file, 'c+');
    if (!$fp) {
        return false;
    }
    if (!@flock($fp, LOCK_EX | LOCK_NB)) {
        @fclose($fp);
        return false;
    }

    @ftruncate($fp, 0);
    $line = 'pid=' . getmypid() . ', started_at=' . date('Y-m-d H:i:s') . PHP_EOL;
    @fwrite($fp, $line);
    @fflush($fp);
    return $fp;
}

function pan123_worker_touch_lock($fp, $loop_count, $stats = array()) {
    if (!is_resource($fp)) return;
    $line = 'pid=' . getmypid()
        . ', loop=' . intval($loop_count)
        . ', heartbeat=' . date('Y-m-d H:i:s')
        . ', processed=' . intval($stats['processed'] ?? 0)
        . ', failed=' . intval($stats['failed'] ?? 0)
        . PHP_EOL;
    @ftruncate($fp, 0);
    @fwrite($fp, $line);
    @fflush($fp);
}

function pan123_worker_unlock($fp) {
    if (is_resource($fp)) {
        @flock($fp, LOCK_UN);
        @fclose($fp);
    }
}

function pan123_worker_run_once($limit) {
    pan123_storage_queue_ensure_schema();
    $config = pan123_storage_config();

    if (empty($config['queue_enable'])) {
        return array(
            'queue_disabled' => 1,
            'limit' => $limit,
            'processed' => 0,
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
            'reset_timeout' => 0,
        );
    }

    $now = time();
    $running_timeout = intval($config['queue_running_timeout'] ?? 900);
    if ($running_timeout < 60) $running_timeout = 60;
    $base_sec = max(1, intval($config['queue_retry_base_sec'] ?? 60));

    $stale_tasks = db_find('pan123_task', array(
        'status' => PAN123_TASK_RUNNING,
        'locked_at' => array('<' => ($now - $running_timeout)),
    ), array('task_id' => 1), 1, 200);

    $reset = 0;
    if (!empty($stale_tasks)) {
        foreach ($stale_tasks as $stale) {
            $stale_id = intval($stale['task_id']);
            $stale_retries = intval($stale['retries'] ?? 0) + 1;
            $stale_max = intval($stale['max_retries'] ?? 5);

            if ($stale_retries >= $stale_max) {
                db_update('pan123_task', array('task_id' => $stale_id), array(
                    'status' => PAN123_TASK_FAIL_FINAL,
                    'progress' => 0,
                    'retries' => $stale_retries,
                    'last_error' => 'worker timeout: exceeded max retries',
                    'updated_at' => $now,
                    'locked_at' => 0,
                ));
                pan123_queue_log('timeout -> FAIL_FINAL', array('task_id' => $stale_id, 'retries' => $stale_retries));
            } else {
                $delay = pan123_task_retry_delay($stale_retries, $base_sec);
                db_update('pan123_task', array('task_id' => $stale_id), array(
                    'status' => PAN123_TASK_FAIL_RETRY,
                    'progress' => 0,
                    'retries' => $stale_retries,
                    'next_run_at' => $now + $delay,
                    'last_error' => 'worker timeout reset (retry ' . $stale_retries . '/' . $stale_max . ')',
                    'updated_at' => $now,
                    'locked_at' => 0,
                ));
            }
            $reset++;
        }
    }

    $tasks = db_find('pan123_task', array(
        'status' => array(PAN123_TASK_PENDING, PAN123_TASK_FAIL_RETRY),
        'next_run_at' => array('<=' => $now),
    ), array('task_id' => 1), 1, $limit);

    if (empty($tasks)) {
        return array(
            'queue_disabled' => 0,
            'limit' => $limit,
            'processed' => 0,
            'success' => 0,
            'failed' => 0,
            'skipped' => 0,
            'reset_timeout' => intval($reset),
        );
    }

    $processed = 0;
    $success = 0;
    $failed = 0;
    $skipped = 0;

    foreach ($tasks as $task) {
        $task_id = intval($task['task_id']);
        $old_status = strval($task['status']);
        $claim_time = time();

        // cheap claim lock (MyISAM-compatible best effort)
        $claimed = db_update('pan123_task', array(
            'task_id' => $task_id,
            'status' => $old_status,
        ), array(
            'status' => PAN123_TASK_RUNNING,
            'progress' => 10,
            'last_error' => '',
            'updated_at' => $claim_time,
            'locked_at' => $claim_time,
        ));
        if (!$claimed) {
            $skipped++;
            continue;
        }

        $task = pan123_task_get($task_id);
        if (empty($task)) {
            $skipped++;
            continue;
        }

        pan123_queue_log('worker start', array(
            'task_id' => $task_id,
            'task_type' => $task['task_type'] ?? '',
            'aid' => intval($task['aid'] ?? 0),
            'pid' => intval($task['pid'] ?? 0),
            'tid' => intval($task['tid'] ?? 0),
            'retries' => intval($task['retries'] ?? 0),
        ));

        $result = pan123_task_process($task, $config);
        if (intval($result['code'] ?? -1) === 0) {
            pan123_task_complete_success($task, $result);
            $success++;
            pan123_queue_log('worker success', array(
                'task_id' => $task_id,
                'fileID' => intval($result['result']['fileID'] ?? 0),
            ));

            // video temporary file cleanup
            if (strval($task['task_type']) === 'video') {
                $p = str_replace('\\', '/', strval($task['local_path'] ?? ''));
                if ($p !== '' && strpos($p, '/pan123_queue/') !== false) {
                    @unlink($task['local_path']);
                }
            }
        } else {
            $err = strval($result['message'] ?? 'unknown error');
            pan123_task_complete_fail($task, $err, $config);
            $failed++;
            pan123_queue_log('worker fail', array(
                'task_id' => $task_id,
                'error' => $err,
            ));
        }

        $processed++;
    }

    return array(
        'queue_disabled' => 0,
        'limit' => $limit,
        'processed' => $processed,
        'success' => $success,
        'failed' => $failed,
        'skipped' => $skipped,
        'reset_timeout' => intval($reset),
    );
}

function pan123_worker_cleanup_orphans($opt = array()) {
    global $conf;
    $upload_path = !empty($conf['upload_path']) ? strval($conf['upload_path']) : APP_PATH . 'upload/';
    $queue_dir = rtrim($upload_path, '/\\') . '/pan123_queue/';
    if (!is_dir($queue_dir)) return;
    $cutoff = time() - 86400 * 7;
    $cleaned = 0;
    $dh = @opendir($queue_dir);
    if (!$dh) return;
    while (($f = readdir($dh)) !== false) {
        if (strpos($f, 'tmp_') !== 0) continue;
        $full = $queue_dir . $f;
        if (!is_file($full)) continue;
        $mt = @filemtime($full);
        if ($mt !== false && $mt < $cutoff) {
            @unlink($full);
            $cleaned++;
        }
    }
    closedir($dh);
    if ($cleaned > 0) {
        pan123_queue_log('orphan cleanup', array('cleaned' => $cleaned));
    }
}

function pan123_worker_purge_old_success() {
    $cutoff = time() - 86400 * 30;
    $old = db_find('pan123_task', array(
        'status' => PAN123_TASK_SUCCESS,
        'updated_at' => array('<' => $cutoff),
    ), array('task_id' => 1), 1, 200);
    if (empty($old)) return;
    $count = 0;
    foreach ($old as $row) {
        db_delete('pan123_task', array('task_id' => intval($row['task_id'])));
        $count++;
    }
    if ($count > 0) {
        pan123_queue_log('purge old success', array('deleted' => $count));
    }
}

$opt = pan123_worker_read_options($argv);
$lock_file = pan123_worker_lock_file();
$lock_fp = pan123_worker_try_lock($lock_file);
if (!$lock_fp) {
    echo "[pan123_worker] already running, skip this process.\n";
    exit(0);
}
register_shutdown_function('pan123_worker_unlock', $lock_fp);

$loop_count = 0;
while (true) {
    $loop_count++;
    $stats = pan123_worker_run_once($opt['limit']);
    pan123_worker_touch_lock($lock_fp, $loop_count, $stats);

    if (!empty($stats['queue_disabled'])) {
        echo "[pan123_worker] queue disabled by config.\n";
        break;
    }

    if (intval($stats['processed']) === 0) {
        echo "[pan123_worker] no due tasks, reset_timeout=" . intval($stats['reset_timeout']) . "\n";
    } else {
        echo "[pan123_worker] limit=" . intval($stats['limit'])
            . ", processed=" . intval($stats['processed'])
            . ", success=" . intval($stats['success'])
            . ", failed=" . intval($stats['failed'])
            . ", skipped=" . intval($stats['skipped'])
            . ", reset_timeout=" . intval($stats['reset_timeout']) . "\n";
    }

    if ($loop_count === 1 || ($loop_count % 60 === 0)) {
        pan123_worker_cleanup_orphans($opt);
        pan123_worker_purge_old_success();
    }

    if (empty($opt['loop'])) {
        break;
    }
    if (!empty($opt['max_loops']) && $loop_count >= intval($opt['max_loops'])) {
        break;
    }
    sleep(intval($opt['sleep']));
}

exit(0);
