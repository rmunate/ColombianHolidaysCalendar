---
title: Notas de lanzamiento
---

# Notas de lanzamiento

## 4.0.0

- Compatibilidad con Laravel 13 y PHP 8.3–8.5, sin eliminar la compatibilidad con Laravel 8–12.
- SQLite regenerado con cobertura de 2000 a 2100. Se corrigieron traslados al lunes y motivos de festivos coincidentes, y se agregó el festivo de Chiquinquirá a partir de 2026.
- La consulta `whereNot()` funciona también con versiones antiguas de Laravel cuyo Query Builder no ofrece ese método.
- GitHub Actions verifica la API y SQLite y compila VitePress antes de desplegar la documentación en GitHub Pages.

### Actualizar desde 3.x

- Los métodos públicos de `Rmunate\Calendar\Colombia` y las columnas que seleccionan se mantienen. `all()` devuelve los resultados en orden cronológico.
- La conexión del calendario es privada y de solo lectura. Usa `Colombia::query()` en lugar de `DB::connection('db_colombiancalendar')`. La conexión ya no se registra en la configuración de Laravel.
- Cuando coinciden varios festivos, `holiday_reason` los separa con ` / `. Si buscas un motivo concreto, usa `like` en lugar de una igualdad exacta para incluir estas fechas.
- Las fechas vacías o imposibles ahora generan `Carbon\Exceptions\InvalidFormatException` en lugar de normalizarse a otro día. Fuera del rango cubierto, los métodos consultan sin resultados.
- Se retiraron el gestor interno de SQLite y los seeders; para regenerar el archivo desde el repositorio, usa `composer calendar:build`.

## 3.0.0

Primera versión con datos en SQLite y filtros con el Query Builder de Laravel.
