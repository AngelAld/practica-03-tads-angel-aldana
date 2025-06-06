<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Proyecto Final TADS

Este proyecto es una aplicación web desarrollada con Laravel, para el apoyo de la gestión de residuos solidos

## Características

- Gestión de empleados y tipos de empleados
- Gestión de vehículos, marcas, modelos y colores
- Gestión de contratos y tipos de contrato
- Gestión de horarios, turnos y asistencias
- Migraciones y seeders para inicializar la base de datos
- Panel administrativo basado en AdminLTE
- Autenticación y autorización de usuarios

## Requisitos

- PHP >= 8.1
- Composer
- Node.js y npm
- MySQL o PostgreSQL

## Instalación

1. Clona el repositorio:

   ```sh
   git clone https://github.com/AngelAld/proyecto-final-tads.git
   cd proyecto-final-tads
   ```

2. Instala las dependencias de PHP con Composer:

    ```sh
    composer install
    ```

3. Instala las dependencias de JavaScript con npm:

    ```sh
    npm install
    ```

4. Copia el archivo de entorno y configura tus variables:

    ```sh
    cp .env.example .env
    ```

5. Genera la clave de la aplicación:

    ```sh
    php artisan key:generate
    ```

6. Configura la conexión a la base de datos en el archivo `.env`.

7. Ejecuta las migraciones y seeders para inicializar la base de datos:

    ```sh
    php artisan migrate --seed
    ```

8. Compila los assets:

    ```sh
    npm run build
    ```

9. Vincula las imagenes:

    ```sh
    php artisan storage:link
    ```

10. Inicia el servidor de desarrollo:

    ```sh
    php artisan serve
    ```

Ahora puedes acceder a la aplicación en `http://localhost:8000`.
