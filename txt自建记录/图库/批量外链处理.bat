@echo off
setlocal enabledelayedexpansion

set "file_path=shu.txt"  REM 请替换为你的文件路径

if not exist "%file_path%" (
    echo 文件不存在: %file_path%
    exit /b
)

for /f "tokens=1,* delims=: " %%a in ('type "%file_path%"') do (
    set "line=%%b"
    echo !line!>> "%file_path%.new"
)

move /y "%file_path%.new" "%file_path%"

echo 处理完成
