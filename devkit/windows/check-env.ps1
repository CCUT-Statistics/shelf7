$ErrorActionPreference = "SilentlyContinue"

Write-Host "== Xiuno local env check ==" -ForegroundColor Cyan

$projectRoot = Resolve-Path (Join-Path $PSScriptRoot "..\..")
Write-Host ("Project: " + $projectRoot)

function Test-Cmd($name) {
    $cmd = Get-Command $name
    if ($null -eq $cmd) {
        Write-Host ("[MISSING] " + $name) -ForegroundColor Yellow
        return $false
    }
    Write-Host ("[OK] " + $name + " -> " + $cmd.Source) -ForegroundColor Green
    return $true
}

$hasPhp = Test-Cmd "php"
$hasMysql = Test-Cmd "mysql"

if ($hasPhp) {
    php -v | Select-Object -First 1
}
if ($hasMysql) {
    mysql --version
}

$confPath = Join-Path $projectRoot "conf\conf.php"
if (Test-Path $confPath) {
    Write-Host "[OK] conf/conf.php exists" -ForegroundColor Green
} else {
    Write-Host "[MISSING] conf/conf.php" -ForegroundColor Yellow
}

$dirs = @("tmp", "log", "upload")
foreach ($d in $dirs) {
    $p = Join-Path $projectRoot $d
    if (!(Test-Path $p)) {
        New-Item -Path $p -ItemType Directory | Out-Null
        Write-Host ("[CREATE] " + $d)
    } else {
        Write-Host ("[OK] " + $d)
    }
}

Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "1) Ensure MySQL database 'xiuno' exists"
Write-Host "2) Run: php -S 127.0.0.1:8080"
Write-Host "3) Open: http://127.0.0.1:8080/install/"
