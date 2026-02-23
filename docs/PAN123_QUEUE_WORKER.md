# Pan123 Queue Worker

## CLI Entry

- `php plugin/pan123_storage/cli/worker.php --limit=20`
- `php plugin/pan123_storage/cli/worker.php --loop --sleep=2 --limit=20`

## Parameters

- `--limit=20`: 每轮最多处理多少条到期任务（范围 1~200，默认 10）。
- `--loop`: 常驻循环模式（不加该参数时，只执行一轮后退出）。
- `--sleep=2`: 循环模式每轮间隔秒数（范围 1~60，默认 2）。
- `--max-loops=100`: 循环模式最多执行多少轮后退出（0 表示不限制，默认 0）。

## Single Instance Lock

- Worker 启动时会尝试抢占锁文件：`upload/log/pan123_worker.lock`。
- 如果已有 worker 正在运行，新进程会直接输出 `already running` 并退出。
- 这可以避免 cron 重叠触发导致的并发处理抖动。

## Scheduler Example

Linux cron (every minute):

```bash
* * * * * /usr/bin/php /var/www/xiuno/plugin/pan123_storage/cli/worker.php --limit=20 >> /var/www/xiuno/upload/log/pan123_worker_cron.log 2>&1
```

Windows Task Scheduler:

- Program: `php`
- Args: `plugin/pan123_storage/cli/worker.php --limit=20`
- Start in: Xiuno site root
- Trigger: every 1 minute

If you use loop mode, run one long-lived process instead of minutely cron:

```bash
php plugin/pan123_storage/cli/worker.php --loop --sleep=2 --limit=20
```

## Inspect Failed Tasks

- Admin page: `插件 -> pan123_storage 设置 -> 队列健康`（可一键重试失败任务）
- DB query (replace table prefix):

```sql
SELECT task_id, task_type, status, retries, max_retries, last_error, updated_at
FROM bbs_pan123_task
WHERE status IN ('FAIL_RETRY', 'FAIL_FINAL')
ORDER BY task_id DESC
LIMIT 100;
```

## Queue Log

- `upload/log/pan123_queue.log`
