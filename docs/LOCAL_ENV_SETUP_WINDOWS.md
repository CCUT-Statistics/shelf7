# Xiuno Local Environment (Windows)

## 1) Prerequisites

- PHP 8.2+ (CLI available as `php`)
- MySQL 5.7+/MariaDB 10.6+ (CLI available as `mysql`)
- Optional: Nginx/Apache. For quick dev you can use PHP built-in server.

## 2) Project-ready defaults already configured

- Standalone git repo is initialized in this project directory.
- `conf/conf.php` is created with local defaults:
  - DB host: `127.0.0.1`
  - DB user/password: `root` / `root`
  - DB name: `xiuno`
  - table prefix: `bbs_`
- Runtime folders are prepared:
  - `tmp/`
  - `log/`
  - `upload/`

If your DB credentials are different, edit `conf/conf.php`.

## 3) Create database

```sql
CREATE DATABASE IF NOT EXISTS xiuno CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 4) Start local web server

From project root:

```powershell
php -S 127.0.0.1:8080
```

Then open:

- Install wizard: `http://127.0.0.1:8080/install/`
- Site: `http://127.0.0.1:8080/`

## 5) Queue worker

Single run:

```powershell
php plugin/pan123_storage/cli/worker.php --limit=20
```

Loop mode:

```powershell
php plugin/pan123_storage/cli/worker.php --loop --sleep=2 --limit=20
```

## 6) Smoke verification

Run `docs/SMOKE_TEST.md` after installation.
