# VPS 测试版部署指南（精简包）

本指南对应 `devkit/release/build-vps-test-release.ps1` 生成的测试包，目标是：

- 仅保留 Xiuno 4.0.7 运行必需文件
- 仅保留推荐插件白名单（降低冲突和全站崩溃风险）
- 保留最小部署说明，便于直接上 VPS 验证

## 1. 在本地生成测试包

在项目根目录执行（Windows PowerShell）：

```powershell
powershell -ExecutionPolicy Bypass -File .\devkit\release\build-vps-test-release.ps1
```

生成目录：

- `release/vps-test/site/`：可直接部署的网站文件
- `release/vps-test/DEPLOY.md`：部署说明（本文件副本）
- `release/vps-test/PLUGIN_ALLOWLIST.txt`：本次保留的插件清单
- `release/vps-test/shelf-5-vps-test.zip`：可直接上传的压缩包

## 2. 包内保留内容（最小可运行）

核心目录：

- `admin/`, `conf/`, `install/`, `lang/`, `model/`, `route/`, `view/`, `xiunophp/`
- 运行时目录：`tmp/`, `upload/`, `log/`

核心文件：

- `index.php`, `index.inc.php`, `model.inc.php`, `.htaccess`, `robots.txt`, `LICENSE.txt`

插件目录仅保留白名单（见 `PLUGIN_ALLOWLIST.txt`），其余插件、禁用插件仓、开发材料不进包。

## 3. 上传并部署到 VPS

1. 上传 `shelf-5-vps-test.zip` 到站点目录（例如 `/www/wwwroot/bbs/`）。
2. 解压到站点根目录。
3. 确认 PHP 版本 `>= 8.2`，并启用扩展：`curl`, `mbstring`, `gd`, `pdo_mysql`（或 `mysqli`）。
4. 确认目录可写：
   - `conf/`
   - `tmp/`
   - `upload/`
   - `log/`
5. 浏览器访问站点，完成 Xiuno 安装向导。
6. 安装完成后删除 `install/` 目录（安全要求）。
7. 配置 Nginx/Apache 伪静态（Xiuno 必需），参考下方 Nginx 配置示例。

### Nginx 伪静态配置要点

Stately 主题会将合并后的 CSS/JS 输出到 `tmp/` 目录（如 `tmp/stately_h.min.css`）。
默认的安全规则 `deny all` 会阻止浏览器加载这些文件，导致主题样式不完整。

```nginx
# 允许 ACME 证书验证（SSL 必需）
location ^~ /.well-known/ {
    allow all;
}

# 后台伪静态（必须在 / 之前）
location /admin/ {
    try_files $uri $uri/ /admin/index.php?$query_string;
}

# 前台伪静态
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

# 允许 Stately 主题的编译产物被浏览器请求
location ~ ^/tmp/.*\.(css|js)$ {
    expires 1d;
    access_log off;
}

# 禁止访问敏感目录（注意 tmp 的 css/js 已在上方放行）
location ~ ^/(conf|log)/ {
    deny all;
}
location ~ ^/tmp/ {
    deny all;
}

# 隐藏点文件
location ~ /\. {
    deny all;
}
```

> **注意**：如果缺少 `location /admin/` 规则，后台的伪静态地址（如插件安装）会走错路由。
> 如果缺少 `location ~ ^/tmp/.*\.(css|js)$` 规则，Stately 主题的核心样式和脚本会被拦截返回 403。

## 4. 首次启用建议（降低冲突风险）

1. 后台先启用 `ai_bootstrap`。
2. 进入 `站点启动器`，按预设执行“① 一键启用推荐插件”。
3. 启用 `site_seo` 后，访问 `/sitemap.xml`，确认可正常输出 XML。
4. 在各搜索引擎站长平台提交 `https://你的域名/sitemap.xml`。
5. 如出现冲突提示，按提示先禁用冲突插件后再执行。
6. 执行 `docs/SMOKE_TEST.md` 中关键项（发帖/回帖/图片上传/搜索/通知）。

## 5. 回滚建议

- 回滚代码：恢复上一版压缩包。
- 回滚数据库：恢复部署前备份。
- 若某插件导致异常：优先在后台禁用该插件，再清理 `tmp/` 缓存。
