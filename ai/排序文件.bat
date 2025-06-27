@echo off
setlocal enabledelayedexpansion

chcp 65001

set "folder=%cd%"

set /p lastCounter=<px.txt
if not defined lastCounter set "lastCounter=0"

set "counter=!lastCounter!"

for %%F in (*.* ) do (
    if /I not "%%~NXF"=="%~NX0" (
        if /I not "%%~NXF"=="px.txt" (
            set "extension=%%~xF"
            set "newname=!counter!!extension!"
            ren "%%F" "!newname!"
            set /a "counter+=1"
        )
    )
)

echo %counter%>px.txt

echo 文件批量重命名完成

timeout /nobreak /t 1 >nul

chcp 936
exit
