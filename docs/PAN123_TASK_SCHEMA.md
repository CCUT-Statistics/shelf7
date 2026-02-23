# Pan123 Task Schema & State Machine

## SQL

```sql
CREATE TABLE IF NOT EXISTS bbs_pan123_task (
  task_id bigint(20) unsigned NOT NULL auto_increment,
  task_type varchar(16) NOT NULL default '',
  aid int(11) unsigned NOT NULL default '0',
  pid int(11) unsigned NOT NULL default '0',
  tid int(11) unsigned NOT NULL default '0',
  uid int(11) unsigned NOT NULL default '0',
  local_path varchar(255) NOT NULL default '',
  remote_name varchar(255) NOT NULL default '',
  parent_file_id bigint(20) unsigned NOT NULL default '0',
  duplicate tinyint(3) unsigned NOT NULL default '1',
  status varchar(16) NOT NULL default 'PENDING',
  progress tinyint(3) unsigned NOT NULL default '0',
  retries tinyint(3) unsigned NOT NULL default '0',
  max_retries tinyint(3) unsigned NOT NULL default '5',
  next_run_at int(11) unsigned NOT NULL default '0',
  last_error varchar(500) NOT NULL default '',
  result_json text NULL,
  locked_at int(11) unsigned NOT NULL default '0',
  created_at int(11) unsigned NOT NULL default '0',
  updated_at int(11) unsigned NOT NULL default '0',
  PRIMARY KEY (task_id),
  KEY idx_type_ref (task_type, aid, pid, tid),
  KEY idx_status_next (status, next_run_at),
  KEY idx_uid (uid),
  KEY idx_locked_at (locked_at)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
```

> Replace `bbs_` with your actual table prefix.

## Idempotency

- Unique reference key at enqueue level: `(task_type, aid, pid, tid)`.
- Same key will not create duplicated pending/running/success tasks.
- `FAIL_FINAL` can be reset and re-queued manually.

## State Machine

- `PENDING` -> waiting worker execution
- `RUNNING` -> worker claimed and processing
- `SUCCESS` -> upload done, map/result updated
- `FAIL_RETRY` -> failed, waiting next retry at `next_run_at`
- `FAIL_FINAL` -> exceeded `max_retries`, requires manual retry

Transitions:

- `PENDING` -> `RUNNING`
- `RUNNING` -> `SUCCESS`
- `RUNNING` -> `FAIL_RETRY`
- `RUNNING` -> `FAIL_FINAL`
- `FAIL_RETRY` -> `RUNNING`
- `FAIL_FINAL` -> `PENDING` (manual retry)

Retry policy:

- Delay = `queue_retry_base_sec * 2^retries`, capped at 24h.
