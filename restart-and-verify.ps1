# Script Restart dan Verifikasi Website Kelurahan Margasari
# Jalankan script ini setelah melakukan perbaikan

Write-Host "================================================================" -ForegroundColor Cyan
Write-Host "     RESTART & VERIFY - Website Kelurahan Margasari      " -ForegroundColor Cyan
Write-Host "================================================================" -ForegroundColor Cyan
Write-Host ""

$projectPath = "d:\Develop Web Laravel\Terbaru web kel\margasaaa"
Set-Location $projectPath

# Step 1: Clear All Caches
Write-Host "1. Clearing all caches..." -ForegroundColor Yellow
php artisan optimize:clear
Write-Host "   [OK] All caches cleared!" -ForegroundColor Green
Write-Host ""

# Step 2: Verify .env configuration
Write-Host "2. Checking .env configuration..." -ForegroundColor Yellow
$envContent = Get-Content ".env" -Raw
if ($envContent -match "FILESYSTEM_DISK=public") {
    Write-Host "   [OK] FILESYSTEM_DISK is set to 'public'" -ForegroundColor Green
} else {
    Write-Host "   [ERROR] WARNING: FILESYSTEM_DISK is NOT set to 'public'" -ForegroundColor Red
    Write-Host "   Please set FILESYSTEM_DISK=public in .env file" -ForegroundColor Red
}
Write-Host ""

# Step 3: Verify storage link
Write-Host "3. Checking storage symlink..." -ForegroundColor Yellow
if (Test-Path "public\storage") {
    Write-Host "   [OK] Storage symlink exists" -ForegroundColor Green
} else {
    Write-Host "   [WARN] Storage symlink not found, creating..." -ForegroundColor Yellow
    php artisan storage:link
    Write-Host "   [OK] Storage symlink created" -ForegroundColor Green
}
Write-Host ""

# Step 4: Run comprehensive tests
Write-Host "4. Running comprehensive tests..." -ForegroundColor Yellow
$testResult = php test_all_features.php
Write-Host $testResult
Write-Host ""

# Step 5: Display important URLs
Write-Host "================================================================" -ForegroundColor Cyan
Write-Host "         IMPORTANT URLS TO TEST                                " -ForegroundColor Cyan
Write-Host "================================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Public Pages:" -ForegroundColor Yellow
Write-Host "  Home:        http://localhost:8000" -ForegroundColor White
Write-Host "  Berita:      http://localhost:8000/berita" -ForegroundColor White
Write-Host "  Pengumuman:  http://localhost:8000/pengumuman" -ForegroundColor White
Write-Host "  Pengaduan:   http://localhost:8000/pengaduan" -ForegroundColor White
Write-Host ""
Write-Host "Admin Pages:" -ForegroundColor Yellow
Write-Host "  Login:       http://localhost:8000/login" -ForegroundColor White
Write-Host "  Dashboard:   http://localhost:8000/admin" -ForegroundColor White
Write-Host "  Posts:       http://localhost:8000/admin/posts" -ForegroundColor White
Write-Host "  Complaints:  http://localhost:8000/admin/complaints" -ForegroundColor White
Write-Host ""
Write-Host "Storage Test URLs:" -ForegroundColor Yellow
Write-Host "  Report:      http://localhost:8000/storage/reports/wBM4QRM4NuGZiq2WtdVR5ytmdIpZsojcOifedXWb.jpg" -ForegroundColor White
Write-Host "  Complaint:   http://localhost:8000/storage/complaints/1760842894_Berita_1.jpg" -ForegroundColor White
Write-Host ""

# Step 6: Instructions
Write-Host "================================================================" -ForegroundColor Cyan
Write-Host "         NEXT STEPS                                            " -ForegroundColor Cyan
Write-Host "================================================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "[!] IMPORTANT: You MUST restart the Laravel server!" -ForegroundColor Red
Write-Host ""
Write-Host "To restart the server:" -ForegroundColor Yellow
Write-Host "  1. Stop the current server (Ctrl+C in the server terminal)" -ForegroundColor White
Write-Host "  2. Run: php artisan serve" -ForegroundColor White
Write-Host "     OR" -ForegroundColor White
Write-Host "  2. Run: .\start-servers.ps1" -ForegroundColor White
Write-Host ""
Write-Host "After restarting, test all the URLs listed above!" -ForegroundColor Green
Write-Host ""
Write-Host "For detailed report, see: LAPORAN_PERBAIKAN.md" -ForegroundColor Cyan
Write-Host ""
Write-Host "================================================================" -ForegroundColor Green
Write-Host "         VERIFICATION COMPLETE!                            " -ForegroundColor Green
Write-Host "================================================================" -ForegroundColor Green
Write-Host ""

# Pause so user can read
Write-Host "Press any key to continue..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
