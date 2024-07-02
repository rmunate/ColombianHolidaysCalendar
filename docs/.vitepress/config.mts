import {defineConfig} from 'vitepress'

export default defineConfig({
    title: "Festivos Colombia",
    description: "Una manera simple, confiable y conveniente para trabajar con las fechas festivas de Colombia! 🚀",
    lang: 'es-ES',
    lastUpdated: false,
    base: '/ColombianHolidaysCalendar',
    themeConfig: {
        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2021-2024 Raul Mauricio Uñate'
        },
        editLink: {
            pattern: 'https://github.com/rmunate/ColombianHolidaysCalendar/tree/main/docs/:path'
        },
        logo: '/img/Logo.png',
        nav: [
            {text: 'v3.0.0', link: '/'},
        ],
        sidebar: [
            {
                text: 'Empezando',
                collapsed: false,
                items: [
                    {text: 'Introducción', link: '/getting-started/introduction'},
                    {text: 'Instalación', link: '/getting-started/installation'},
                    {text: 'Notas De Lanzamiento', link: '/getting-started/changelog'},
                ]
            }, {
                text: 'Uso',
                collapsed: false,
                items: [
                    {text: 'Consultas', link: '/usage/class-methods'},
                ]
            }, {
                text: 'Contribute',
                collapsed: false,
                items: [
                    {text: 'Reporte De Error', link: 'contribute/report-bugs'},
                    {text: 'Contribución', link: 'contribute/contribution'}
                ]
            }
        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/rmunate/ColombianHolidaysCalendar'}
        ],
        search: {
            provider: 'local'
        }
    },
    head: [
        ['link', {
                rel: 'stylesheet',
                href: '/ColombianHolidaysCalendar/css/style.css'
            }
        ],
        ['link', {
                rel: 'icon',
                href: '/ColombianHolidaysCalendar/img/Logo.png',
                type: 'image/png'
            }
        ],
        ['meta', {
                property: 'og:image',
                content: '/ColombianHolidaysCalendar/img/logo-github.png'
            }
        ],
        ['meta', {
                property: 'og:image:secure_url',
                content: '/ColombianHolidaysCalendar/img/logo-github.png'
            }
        ],
        ['meta', {
                property: 'og:image:width',
                content: '600'
            }
        ],
        ['meta', {
                property: 'og:image:height',
                content: '400'
            }
        ],
        ['meta', {
                property: 'og:title',
                content: 'Calendario Festivos Colombia'
            }
        ],
        ['meta', {
                property: 'og:description',
                content: 'Una manera simple, confiable y conveniente para trabajar con las fechas festivas de Colombia! 🚀'
            }
        ],
        ['meta', {
                property: 'og:url',
                content: 'https://rmunate.github.io/ColombianHolidaysCalendar/'
            }
        ],
        ['meta', {
                property: 'og:type',
                content: 'website'
            }
        ],
    ],
})
