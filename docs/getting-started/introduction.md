---
title: Introducción
---

# Calendario de Festivos de Colombia

![Calendario de Festivos de Colombia](/img/logo-full-scream.png)

El paquete permite consultar si un día es festivo, conocer su motivo y realizar búsquedas por rangos o partes de una fecha con el Query Builder de Laravel. Todos los datos vienen incluidos en una base SQLite de solo lectura.

## Cobertura del calendario

- Desde el **1 de enero de 2000** hasta el **31 de diciembre de 2100**, inclusive.
- Festivos nacionales según la [Ley 51 de 1983](https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=4954). La base incluye las fechas observadas de descanso, con el traslado al lunes para los días a los que aplica.
- Nuestra Señora del Rosario de Chiquinquirá desde 2026, según el artículo 6 de la [Ley 2578 de 2026](https://lector.ramajudicial.gov.co/SIDN/NORMATIVA/TEXTOS_COMPLETOS/7_LEYES/LEYES%202026/Ley%202578%20de%202026.pdf). El primer descanso se observó el lunes **13 de julio de 2026**.
- También incluye todos los domingos, como en la versión anterior. Si un festivo nacional cae en domingo, se conserva su motivo nacional.

Cada fecha tiene una sola fila. Si coinciden dos festivos nacionales, el motivo incluye ambos. Las fechas futuras se calculan con las leyes indicadas: el paquete no sigue cambios normativos en tiempo real ni incluye festivos locales, jornadas cívicas extraordinarias o calendarios de cada empleador.

Continúa con la [instalación](./installation.md) o consulta los [ejemplos de uso](../usage/class-methods.md).
