@ECHO OFF
cd /D %~dp0

call :stop_apache
call :stop_mysql
pause
goto :eof

:start_apache
Apache24\bin\httpd -k install -n .apache
net start .apache
goto :eof

:stop_apache
(sc query .apache | find ".apache">nul && net stop .apache)
(sc query .apache | find ".apache">nul && sc delete .apache)
(tasklist /FI "IMAGENAME eq httpd.exe" | find "httpd">nul && taskkill /f /im httpd.exe) 2>&0
goto :eof

:start_mysql
mariadb-10.2.9-winx64\bin\mysqld --install .mysql
(sc query .mysql | find ".mysql">nul && net start .mysql)
goto :eof

:stop_mysql
(sc query .mysql | find ".mysql">nul && net stop .mysql)
(sc query .mysql | find ".mysql">nul && sc delete .mysql)
(tasklist /FI "IMAGENAME eq mysqld.exe" | find "mysqld">nul && taskkill /f /im mysqld.exe) 2>&0
goto :eof
