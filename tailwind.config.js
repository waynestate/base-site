const twColors = require('tailwindcss/colors')
const path = require("path");

const baseColors = {
    transparent: 'transparent',
    current: 'currentColor',
    black: '#181a19',
    gray: {
        50: '#f9fafb',
        100: '#f5f5f5',
        200: '#e5e5e5',
        300: '#d4d4d4',
        400: '#a3a3a3',
        DEFAULT: '#a3a3a3',
        500: '#737373',
        600: '#525252',
        700: '#404040',
        800: '#262626',
        900: '#171717',
    },
    green: {
        50: '#cedddb',
        100: '#9ebbb6',
        200: '#6d9892',
        300: '#3d766d',
        400: '#0c5449',
        DEFAULT: '#0c5449',
        500: '#0b4a40',
        600: '#094038',
        700: '#08352f',
        800: '#062b27',
        900: '#05211e',
    },
    gold: {
        50: '#fff5d6',
        100: '#ffebad',
        200: '#ffe085',
        300: '#ffd65c',
        400: '#ffcc33',
        DEFAULT: '#ffcc33',
        500: '#edbd2c',
        600: '#dbae25',
        700: '#c89f1f',
        800: '#b69018',
        900: '#a48111',
    }
}

const screens = {
    'sm': '420px',
    'md': '576px',
    'lg': '732px',
    'xl': '888px',
    'xxl': '1044px',
    '2xl': '1044px',
    '3xl': '1200px',
    'mt': '780px', // Adjust this based on the top menu width
    'print': {'raw': 'print'},
}

module.exports = {
    content: [
        path.join(__dirname, "resources/views/**/*.blade.php"),
        path.join(__dirname, "styleguide/Views/**/*.blade.php"),
        path.join(__dirname, "factories/**/*.php"),
        path.join(__dirname, "resources/js/**/*.js"),
        path.join(__dirname, "node_modules/slideout/dist/slideout.js"),
        path.join(__dirname, "node_modules/flickity/dist/flickity.pkgd.js"),
        path.join(__dirname, "node_modules/mediabox/dist/mediabox.js"),
    ],
    safelist: [
        {
            pattern: /at-/,
        },
        {
            pattern: /w-[1-5]\/[1-5]/,
            variants: ['sm','md','lg','xl','2xl','3xl','mt'],
        },
        {
            pattern: /grid(-cols-[1-4])?/,
            variants: ['sm','md','lg','xl','2xl','3xl','mt'],
        },
        {
            pattern: /columns(-[1-4])?/,
            variants: ['sm','md','lg','xl','2xl','3xl','mt'],
        },
        '/form_responses/'
    ],
    theme: {
        screens: screens,
        fontFamily: {
            'sans': [
                'Lato',
                'system-ui',
                'BlinkMacSystemFont',
                '-apple-system',
                'Segoe UI',
                'Roboto',
                'Oxygen',
                'Ubuntu',
                'Cantarell',
                'Fira Sans',
                'Droid Sans',
                'Helvetica Neue',
                'sans-serif',
            ],
            'serif': [
                'Georgia',
                'Times',
                'Times New Roman',
                'serif',
            ],
        },
        extend: {
            colors: baseColors,
            maxWidth: {
                'half': '50%',
                'screen-xxxl': screens.xxxl,
            },
            padding: {
                '3/4': '75%',
                '16/9': '56.35%',
                'hero': '36.3%',
                'full': '100%',
                'portrait' : '133%',
            },
            spacing: {
                '14': '3.5rem',
            },
            margin: {
                '17': '4.25rem',
                '19': '4.75rem',
            },
            minHeight: {
                'hero': '36.3vw',
            },
            boxShadow: {
                'white': '0 7px 0 '+ twColors.white +', 0 14px 0 '+ twColors.white,
                'grey': '0 7px 0 '+ twColors.gray +', 0 14px 0 '+ twColors.gray,
            },
            opacity: {
                '65': '.65',
            },
        },
    },
}
