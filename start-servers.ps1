# =======================================================
# AUTO START LARAVEL + NODE.JS CHATBOT (PowerShell)
# =======================================================
# Cara pakai: 
#   1. Buka PowerShell
#   2. cd "d:\Develop Web Laravel\Terbaru web kel\margasaaa"
#   3. .\start-servers.ps1
# =======================================================

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "  Starting Laravel + Chatbot Servers" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Get script directory
$scriptPath = Split-Path -Parent $MyInvocation.MyCommand.Path

# Check and kill any process using port 3000
Write-Host "[1/2] Checking for processes on port 3000..." -ForegroundColor Yellow
try {
    $process = Get-NetTCPConnection -LocalPort 3000 -ErrorAction SilentlyContinue | Select-Object -ExpandProperty OwningProcess -First 1
    if ($process) {
        Write-Host "      Killing existing process on port 3000 (PID: $process)..." -ForegroundColor Red
        Stop-Process -Id $process -Force -ErrorAction SilentlyContinue
        Start-Sleep -Seconds 2
        Write-Host "      Port 3000 cleared!" -ForegroundColor Green
    } else {
        Write-Host "      Port 3000 is free" -ForegroundColor Green
    }
} catch {
    Write-Host "      Port 3000 is free" -ForegroundColor Green
}

# Start Node.js Chatbot Server in minimized window
Write-Host "[1/2] Starting Node.js Chatbot Server..." -ForegroundColor Yellow
$chatbotPath = Join-Path $scriptPath "kelurahan-chatbot-gemini"
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$chatbotPath'; Write-Host 'Chatbot Server Running on http://localhost:3000' -ForegroundColor Green; npm start" -WindowStyle Minimized

# Wait for Node.js to initialize
Write-Host "      Waiting for Node.js to start..." -ForegroundColor Gray
Start-Sleep -Seconds 5

# Start Laravel Web Server in normal window
Write-Host "[2/2] Starting Laravel Web Server..." -ForegroundColor Yellow
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$scriptPath'; Write-Host 'Laravel Server Running on http://localhost:8000' -ForegroundColor Green; php artisan serve"

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "  Servers Started Successfully!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "  Laravel:  " -NoNewline; Write-Host "http://localhost:8000" -ForegroundColor Cyan
Write-Host "  Chatbot:  " -NoNewline; Write-Host "http://localhost:3000" -ForegroundColor Cyan
Write-Host ""
Write-Host "  Open browser: " -NoNewline; Write-Host "http://localhost:8000" -ForegroundColor Yellow
Write-Host ""
Write-Host "  To stop: Close the terminal windows or press CTRL+C" -ForegroundColor Gray
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Optional: Auto-open browser
Write-Host "Opening browser in 3 seconds..." -ForegroundColor Gray
Start-Sleep -Seconds 3
Start-Process "http://localhost:8000"

Write-Host ""
Write-Host "Done! Servers are running in background." -ForegroundColor Green
Write-Host "Press any key to exit this window..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
