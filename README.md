# Calendario de Festivos de Colombia

Consulta los festivos nacionales y los domingos de Colombia del **2000 al 2100**, inclusive. El paquete distribuye un archivo SQLite de solo lectura y no necesita una API externa, migraciones ni tablas en la base de datos de tu aplicación.

## Instalación

La versión **4.0.0** es compatible con Laravel **8 a 13**. Laravel 13 requiere **PHP 8.3 o posterior**; para las versiones anteriores, usa una versión de PHP compatible con tu aplicación (como mínimo PHP 7.4 para este paquete). El controlador `pdo_sqlite` debe estar habilitado.

```shell
composer require "rmunate/calendario-colombia:^4.0"
```

## Uso rápido

```php
use Rmunate\Calendar\Colombia;

Colombia::isHoliday('2026-07-13'); // true
Colombia::getDescriptionIfHoliday('2026-07-13');
// 'Día de Nuestra Señora del Rosario de Chiquinquirá'

// Festivos nacionales de 2026, sin incluir los domingos que no son festivo nacional.
$festivos = Colombia::where('year', 2026)
    ->where('holiday_reason', '!=', 'Día Domingo Festivo')
    ->orderBy('full_date')
    ->get();
```

El calendario aplica la [Ley 51 de 1983](https://www.funcionpublica.gov.co/eva/gestornormativo/norma.php?i=4954) e incorpora desde 2026 el festivo de Chiquinquirá ([Ley 2578 de 2026, art. 6](https://lector.ramajudicial.gov.co/SIDN/NORMATIVA/TEXTOS_COMPLETOS/7_LEYES/LEYES%202026/Ley%202578%20de%202026.pdf)). Los años futuros se proyectan con estas reglas; no se incluyen días cívicos, regionales o excepcionales.

Consulta la [documentación completa](https://rmunate.github.io/ColombianHolidaysCalendar/) o las [notas de la versión 4.0.0](docs/getting-started/changelog.md).

## Licencia

[MIT](LICENSE.md) · [Patrocinar el proyecto](https://github.com/sponsors/rmunate)
