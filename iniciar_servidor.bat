@echo off
title Servidor Web - Panaderia y Cafeteria Danilo
cd /d "%~dp0"
echo ===================================================
echo   Iniciando Servidor Web Local - Panaderia Danilo
echo ===================================================
echo.
echo   [1] Landing Page:   http://localhost:8000/index.html
echo   [2] Carta Digital:  http://localhost:8000/carta.html
echo   [3] Panel de BD:    http://localhost:8000/backend/ver_pedidos.php
echo.
echo   Presiona Ctrl + C para detener el servidor.
echo ===================================================
start http://localhost:8000/index.html
"C:\Users\paolo\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.3_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" -S localhost:8000
pause
