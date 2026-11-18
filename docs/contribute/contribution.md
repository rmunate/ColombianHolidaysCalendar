---
title: Contribución
---

<script setup>
import { VPTeamMembers } from 'vitepress/theme'

const members = [
  {
    avatar: 'https://avatars.githubusercontent.com/u/91748598?v=4',
    name: 'Raúl Mauricio Uñate Castro',
    title: 'Creator | Bogotá DC - Colombia',
    links: [
      { icon: 'github', link: 'https://github.com/rmunate'},
      { icon: 'linkedin', link: 'https://www.linkedin.com/in/raul-mauricio-unate-castro/' },
      { icon: 'facebook', link: 'https://www.facebook.com/people/Code-Maestro/100093438305767/' },
      { icon: 'instagram', link: 'https://www.instagram.com/code.maestro/' },
      { icon: 'twitter', link: 'https://twitter.com/rmunate' },
    ]
  }
]
</script>

# Contribuciones

Crea tu rama a partir de `master` y abre un pull request con los cambios, las pruebas y la documentación que correspondan.

## Verificar cambios

Para desarrollar la biblioteca, habilita también la extensión PHP `calendar`, usada para calcular la fecha de Pascua en la generación de datos.

```shell
composer install
composer test
composer calendar:check
```

El generador es la fuente de las reglas y no se ejecuta en las aplicaciones consumidoras. Cuando cambie una norma o la cobertura, actualiza el generador y prueba las fechas afectadas. Luego ejecuta `composer calendar:build` e incluye el archivo SQLite regenerado en el pull request. `composer calendar:check` verifica la integridad y compara el contenido, no los bytes, con una base recién generada.

Para la documentación usa Node.js 24:

```shell
npm ci
npm run docs:dev
npm run docs:build
```

El sitio usa VitePress 1.x con una versión corregida de Vite 6 fijada mediante `overrides`. Al actualizar VitePress, comprueba si el reemplazo sigue siendo necesario.

## Desplegar y publicar

1. En GitHub, configura **Settings → Pages → Build and deployment → Source → GitHub Actions**. Si el entorno `github-pages` usa reglas de despliegue, asegúrate de que permitan `master`.
2. Al integrar cambios en `master`, el flujo **Verify release and deploy documentation** ejecuta las pruebas en la matriz de PHP y Laravel, verifica SQLite y compila el sitio. Solo publica cuando pasan las verificaciones. También se puede ejecutar manualmente desde `master`. Los pull requests y las etiquetas ejecutan las verificaciones, pero no publican en Pages.
3. Para publicar el paquete, crea la etiqueta `v4.0.0` sobre el commit verificado y sincroniza la versión en [Packagist](https://packagist.org/packages/rmunate/calendario-colombia). Composer obtiene la versión de la etiqueta, no de un campo `version` en el manifiesto.

## Contribuidores

Hasta la fecha, los siguientes desarrolladores han contribuido con su conocimiento.

A quienes agradecemos por apoyar haciendo la programación más fácil.

<VPTeamMembers size="small" :members="members" />

Contribuciones bajo la [licencia MIT](https://github.com/rmunate/ColombianHolidaysCalendar/blob/master/LICENSE.md). Puedes [patrocinar el proyecto en GitHub](https://github.com/sponsors/rmunate).