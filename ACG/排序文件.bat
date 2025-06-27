@echo off
setlocal enabledelayedexpansion

rem 获取脚本的文件名
set "script_name=%~nx0"

rem 遍历当前文件夹内的所有文件
for %%f in (*) do (
    rem 排除脚本自己
    if /I NOT "%%f"=="!script_name!" (
        rem 检查文件名是否已经是五位数字
        set "filename=%%~nf"
        if not "!filename:~0,5!"=="!filename!" (
            rem 生成5位随机数字
            set "random_number="
            for /L %%i in (1,1,5) do (
                set /a "digit=!random! %% 10"
                set "random_number=!random_number!!digit!"
            )

            rem 重命名文件
            ren "%%f" "!random_number!%%~xf"
        )
    )
)

endlocal
exit
