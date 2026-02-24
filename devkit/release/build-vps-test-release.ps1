param(
    [string]$SourceRoot = "",
    [string]$OutputRoot = ""
)

$ErrorActionPreference = "Stop"

if ([string]::IsNullOrWhiteSpace($SourceRoot)) {
    $SourceRoot = (Resolve-Path (Join-Path $PSScriptRoot "..\..")).Path
} else {
    $SourceRoot = (Resolve-Path $SourceRoot).Path
}

if ([string]::IsNullOrWhiteSpace($OutputRoot)) {
    $OutputRoot = Join-Path $SourceRoot "release\vps-test"
}

$SiteRoot = Join-Path $OutputRoot "site"
$ZipPath = Join-Path $OutputRoot "shelf-5-vps-test.zip"
$DeployGuideSource = Join-Path $SourceRoot "docs\TEST_VPS_DEPLOY.md"
$DeployGuideTarget = Join-Path $OutputRoot "DEPLOY.md"
$PluginAllowlistFile = Join-Path $OutputRoot "PLUGIN_ALLOWLIST.txt"

$CoreDirs = @(
    "admin",
    "conf",
    "install",
    "lang",
    "model",
    "route",
    "view",
    "xiunophp",
    "tmp",
    "upload",
    "log"
)

$CoreFiles = @(
    ".htaccess",
    "index.php",
    "index.inc.php",
    "model.inc.php",
    "robots.txt",
    "LICENSE.txt"
)

$PluginAllowlist = @(
    "ai_bootstrap",
    "site_seo",
    "pan123_storage",
    "abs_menu",
    "abs_theme_stately",
    "abs_themeacp_stately",
    "huux_notice",
    "fox_search",
    "fox_tags",
    "haya_post_like",
    "haya_favorite",
    "huux_tinymce",
    "till_thread_cover",
    "till_hot_thread",
    "till_lightbox",
    "till_post_replies",
    "xn_ipaccess",
    "qt_sensitive_word",
    "ob_feedback",
    "till_users_widget",
    "ac_movielink"
)

Write-Host "SourceRoot: $SourceRoot"
Write-Host "OutputRoot: $OutputRoot"

if (Test-Path $OutputRoot) {
    Remove-Item -Path $OutputRoot -Recurse -Force
}
New-Item -Path $OutputRoot -ItemType Directory | Out-Null
New-Item -Path $SiteRoot -ItemType Directory | Out-Null

foreach ($dir in $CoreDirs) {
    $src = Join-Path $SourceRoot $dir
    if (!(Test-Path $src)) {
        throw "Missing required directory: $src"
    }
    $dst = Join-Path $SiteRoot $dir
    Copy-Item -Path $src -Destination $dst -Recurse -Force
}

foreach ($file in $CoreFiles) {
    $src = Join-Path $SourceRoot $file
    if (!(Test-Path $src)) {
        throw "Missing required file: $src"
    }
    $dst = Join-Path $SiteRoot $file
    Copy-Item -Path $src -Destination $dst -Force
}

$PluginRoot = Join-Path $SiteRoot "plugin"
if (Test-Path $PluginRoot) {
    Remove-Item -Path $PluginRoot -Recurse -Force
}
New-Item -Path $PluginRoot -ItemType Directory | Out-Null

$MissingPlugins = @()
foreach ($plugin in $PluginAllowlist) {
    $src = Join-Path $SourceRoot ("plugin\" + $plugin)
    if (!(Test-Path $src)) {
        $MissingPlugins += $plugin
        continue
    }
    $dst = Join-Path $PluginRoot $plugin
    Copy-Item -Path $src -Destination $dst -Recurse -Force
}

Set-Content -Path $PluginAllowlistFile -Value ($PluginAllowlist -join [Environment]::NewLine) -Encoding utf8

if (!(Test-Path $DeployGuideSource)) {
    throw "Missing deploy guide: $DeployGuideSource"
}
Copy-Item -Path $DeployGuideSource -Destination $DeployGuideTarget -Force

$ZipItems = @(
    (Join-Path $OutputRoot "site"),
    $DeployGuideTarget,
    $PluginAllowlistFile
)
Compress-Archive -Path $ZipItems -DestinationPath $ZipPath -Force

if ($MissingPlugins.Count -gt 0) {
    Write-Warning ("Missing plugins in allowlist: " + ($MissingPlugins -join ", "))
}

Write-Host ""
Write-Host "Build complete."
Write-Host "Site root: $SiteRoot"
Write-Host "Deploy guide: $DeployGuideTarget"
Write-Host "Zip package: $ZipPath"
