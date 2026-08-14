@echo off
echo Resetting Database...
cd /d "%~dp0"
php artisan migrate:fresh --seed
echo.
echo Database reset complete!
echo Default credentials:
echo   Admin: admin@payroll.com / password123
echo   Staff: staff@payroll.com / password123
echo   Employee: employee@payroll.com / password123
echo.
pause
