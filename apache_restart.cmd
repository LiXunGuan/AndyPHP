@ECHO OFF
cd /D %~dp0

(sc query .apache | find ".apache">nul && net stop .apache)
(sc query .apache | find ".apache">nul && net start .apache)
