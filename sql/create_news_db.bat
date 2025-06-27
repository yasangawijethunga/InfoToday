@echo off
setlocal

:: Set MySQL path for WAMP
set MYSQL_BIN=C:\wamp64\bin\mysql\mysql9.1.0\bin\mysql.exe

:: Set MySQL login credentials
set DB_USER=root
set DB_PASS=

:: SQL file path
set SQL_FILE=C:\wamp64\www\InfoToday\sql\news_db.sql

:: Run the SQL script
echo Creating database from %SQL_FILE% ...
"%MYSQL_BIN%" -u %DB_USER% -p%DB_PASS% < "%SQL_FILE%"

if %ERRORLEVEL%==0 (
    echo ✅ Database created successfully!
) else (
    echo ❌ Error occurred while creating database.
)

pause
