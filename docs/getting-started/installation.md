---
title: Instalación
---

# Instalación

## Requisitos

- **Laravel 8, 9, 10, 11, 12 o 13**. Se admiten las actualizaciones menores y de parche de estas ramas. Las versiones mayores posteriores se validarán por separado.
- **PHP 7.4 o 8.x**, respetando los requisitos de tu versión de Laravel. Laravel 13 requiere como mínimo [PHP 8.3](https://laravel.com/docs/13.x/releases#php-8).
- Las extensiones PHP `PDO` y `pdo_sqlite` habilitadas. La extensión `sqlite3` no es necesaria.

## Instalar o actualizar a 4.0.0

Desde la raíz de tu aplicación Laravel:

```shell
composer require "rmunate/calendario-colombia:^4.0"
```

No debes ejecutar migraciones ni registrar un proveedor de servicios. El paquete abre su archivo SQLite en modo de solo lectura con una conexión separada de las de Laravel. No usa ni cambia tu conexión por defecto.

Si Composer reporta que falta `pdo_sqlite`, habilita la extensión en la configuración de PHP utilizada por Composer y por la aplicación. Puedes comprobar qué archivo de configuración usa la CLI con `php --ini` y qué módulos están cargados con `php -m`.

Si vienes de la versión 3, revisa los [cambios de comportamiento y migración](./changelog.md).
