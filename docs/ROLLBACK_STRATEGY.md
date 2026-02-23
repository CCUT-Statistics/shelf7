# Minimal Rollback Strategy

Use this before any plugin/theme iteration.

## 1) Must-Backup Directories

- `conf/`
- `upload/`
- `plugin/`

Recommended backup command idea:

- Create a timestamped archive of these three paths before each major change.

## 2) Database Export

Use one of the following:

- `mysqldump` (preferred):
  - `mysqldump -h <host> -u <user> -p<password> <database> > backup_<date>.sql`
- phpMyAdmin export (if command line unavailable):
  - Export full database as SQL (structure + data).

## 3) Fast Rollback Steps

1. Disable maintenance-impacting tasks (worker/cron, if enabled).
2. Restore DB from latest SQL backup.
3. Restore `conf/`, `upload/`, `plugin/` from matching filesystem backup.
4. Clear `tmp/` cache.
5. Re-run `docs/SMOKE_TEST.md`.

## 4) Rule of Thumb

- One backup set per iteration batch.
- Do not run destructive plugin operations without a fresh DB dump.
