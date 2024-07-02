---
title: Installation
editLink: true
outline: deep
---
# Instalación

## Requisitos

Para asegurar el funcionamiento adecuado de este paquete en tu proyecto, asegúrate de cumplir con los siguientes requisitos:

- **Versión de Laravel:** 9.0 o superior.
- **Versión de PHP:** 7.4 o superior.

Además, en tu configuración `php.ini`, asegúrate de tener las siguientes extensiones habilitadas:
- `extension=sqlite3`
- `extension=pdo_sqlite`

Estas extensiones son fundamentales ya que permiten un manejo eficiente de los datos en SQLite para el calendario de Colombia, asegurando un rendimiento óptimo sin un consumo excesivo de memoria.

## Instalación

### Composer

Para instalar este paquete, ejecuta el siguiente comando de Composer:

```bash
composer require rmunate/calendario-colombia
```

Composer se encargará de descargar la versión más reciente compatible (3.0 o superior).