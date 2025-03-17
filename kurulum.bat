@echo off
echo MMS Web Site Kurulumu Basliyor...
echo.

REM XAMPP'ın çalışıp çalışmadığını kontrol et
if not exist C:\xampp\mysql\bin\mysql.exe (
  echo XAMPP kurulu olmayabilir veya yanlis konumda.
  echo Lutfen XAMPP'i C:\xampp dizinine kurun.
  echo.
  pause
  exit /b
)

REM MySQL'in çalışıp çalışmadığını kontrol et
cd C:\xampp\mysql\bin
mysql --user=root --password= -e "SELECT 'MySQL calisiyor';" >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
  echo MySQL calismiyorsa, lutfen XAMPP Control Panel'den MySQL'i calistirin.
  echo.
  pause
  exit /b
)

echo MySQL calisir durumda. Veritabani kurulum islemi basliyor...
echo.

REM Web tarayıcıda PHP script'ini çalıştır
start http://localhost/mmsweb-pro/db/import_sql.php

echo Veritabani kurulumu tamamlandi.
echo.
echo Siteyi goruntulemek icin tarayicinizda http://localhost/mmsweb-pro adresini acin.
echo.
pause 