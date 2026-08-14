param(
    [string]$commitMessage = "Update Laravel project"
)

$gitPath = 'C:\Program Files\Git\cmd\git.exe'
$projectPath = 'C:\xampp\htdocs\Bren-Payroll-information-system'

if (-not (Test-Path $gitPath)) {
    Write-Host 'Git not found. Install Git for Windows first.' -ForegroundColor Red
    exit 1
}

Set-Location $projectPath

Write-Host 'Staging files...' -ForegroundColor Cyan
& $gitPath add .

Write-Host 'Creating commit...' -ForegroundColor Cyan
& $gitPath commit -m $commitMessage

Write-Host 'Pushing to GitHub...' -ForegroundColor Yellow
Write-Host 'Use:' -ForegroundColor Yellow
Write-Host '  Username: PVTec' -ForegroundColor Yellow
Write-Host '  Password: your GitHub PAT' -ForegroundColor Yellow

& $gitPath push origin main
