---
title: Introduction
editLink: true
outline: deep
---

![logo-spell-number](/img/logo-full-scream.png)

## Introducción

Este paquete fue desarrollado con el propósito de ofrecer una solución sencilla, fácil y conveniente para trabajar con las fechas festivas de Colombia. En numerosos sistemas empresariales, como ERP, CRM y aplicaciones de gestión de calendarios, es crucial determinar si una fecha específica es festiva, calcular la cantidad de días festivos entre períodos de tiempo, y más.

El paquete proporciona acceso a una extensa base de datos de fechas festivas sin la necesidad de depender de APIs externas o almacenar grandes volúmenes de datos adicionales en la base de datos principal del sistema. Esto asegura un manejo eficiente y directo de la información requerida.

Con esta herramienta, los desarrolladores pueden integrar fácilmente la funcionalidad de calendario colombiano en sus aplicaciones, mejorando la precisión y la eficiencia del manejo de fechas festivas sin complicaciones adicionales.

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

## Licencia

Este proyecto está bajo la [Licencia MIT](https://choosealicense.com/licenses/mit/).

🌟 ¡Apoya Mis Proyectos! 🚀

[![Conviértete en Patrocinador](https://img.shields.io/badge/-Conviértete%20en%20Patrocinador-blue?style=for-the-badge&logo=github)](https://github.com/sponsors/rmunate)

Haz cualquier contribución que consideres adecuada; el código es completamente tuyo. Juntos, podemos hacer cosas increíbles y mejorar el mundo del desarrollo. Tu apoyo es invaluable. ✨

¡Si tienes ideas, sugerencias o simplemente quieres colaborar, estamos abiertos a todo! Únete a nuestra comunidad y sé parte de nuestro camino hacia el éxito! 🌐👩‍💻👨‍💻