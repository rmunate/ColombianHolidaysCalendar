import { defineConfig } from 'vitepress'

/** GitHub Actions obtiene la URL de Pages; el valor local sirve para previsualizar el sitio del repositorio. */
const base = process.env.DOCS_BASE || '/ColombianHolidaysCalendar/'
const site = new URL(base, process.env.DOCS_ORIGIN || 'https://rmunate.github.io')
const repository = 'https://github.com/rmunate/ColombianHolidaysCalendar'
const description = 'Consulta los festivos nacionales y los domingos de Colombia en Laravel.'

export default defineConfig({
    title: 'Festivos Colombia',
    description,
    lang: 'es-CO',
    base,
    themeConfig: {
        footer: {
            message: 'Publicado bajo la licencia MIT.',
            copyright: 'Copyright © 2023 Raúl Mauricio Uñate Castro'
        },
        editLink: {
            pattern: `${repository}/edit/master/docs/:path`,
            text: 'Editar esta página en GitHub'
        },
        logo: '/img/Logo.png',
        nav: [
            { text: 'v4.0.0', link: '/getting-started/changelog' }
        ],
        sidebar: [
            {
                text: 'Primeros pasos',
                items: [
                    { text: 'Introducción', link: '/getting-started/introduction' },
                    { text: 'Instalación', link: '/getting-started/installation' },
                    { text: 'Notas de lanzamiento', link: '/getting-started/changelog' }
                ]
            }, {
                text: 'Uso',
                items: [
                    { text: 'Consultas', link: '/usage/class-methods' }
                ]
            }, {
                text: 'Colaboración',
                items: [
                    { text: 'Reportar un error', link: '/contribute/report-bugs' },
                    { text: 'Contribución', link: '/contribute/contribution' }
                ]
            }
        ],
        socialLinks: [
            { icon: 'github', link: repository }
        ],
        search: {
            provider: 'local'
        }
    },
    head: [
        ['link', { rel: 'stylesheet', href: `${base}css/style.css` }],
        ['link', { rel: 'icon', href: `${base}img/Logo.png`, type: 'image/png' }],
        ['meta', { property: 'og:image', content: new URL('img/logo-github.png', site).href }],
        ['meta', { property: 'og:title', content: 'Calendario de Festivos de Colombia' }],
        ['meta', { property: 'og:description', content: description }],
        ['meta', { property: 'og:url', content: site.href }],
        ['meta', { property: 'og:type', content: 'website' }]
    ]
})
