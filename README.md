# Lectura veloz y comprensión

## ¿Que es ésto?

Un simple proyecto para mejorar la velocidad de lectura de palabras por minuto.
Las palabras se muestran una tras otra en un espacio fijo, y van cambiando respecto al tiempo que el usuario haya indicado.

## Instalación

`git clone URL` y luego `composer install` y finalmente `composer update`.

Dentro de la carpeta viene la estructura de la BD.
El nombre por defecto es `fast_reading`, pero puede llamarse como quieran (Solo deben especificar en el .env que se ha cambiado el nombre).

## Setup

Por defecto se ha ignorado el archivo `.env`, y dentro de la carpeta viene una copia llamada `_.env`la cual basta con cambiar de nombre para que funcione como es debido.

## Info

El proyecto usa COde Igniter 4 como su framework, con el ligero cambio que `index.php` desde un inicio no está siendo usado en las rutas.

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
