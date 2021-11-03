const colors = require('tailwindcss/colors')

const myColors = {
    transparent: 'transparent',
    black: '#181a19',
    current: '#fff',
    gray: {
        100: '#f2f2f2',
        200: '#e6e6e6',
        300: '#d9d9d9',
        400: '#babfbf',
        500: '#949999',
        600: '#575959',
        700: '#323333',
    },
    /*
     * update these values in the blade.php and .scss files and un-comment them out
    green: {
        green-lightest-to-green-50: '#acc9c0',
        50: '#cedddb',
        100: '#9ebbb6',
        green-lighter-to-green-200: '#71a192',
        200: '#6d9892',
        green-light-to-green-300: '#3d7a67',
        300: '#3d766d',
        DEFAULT: '#0c5449',
        500: '#0b4a40',
        600: '#094038',
        green-dark-to-green-600: '#093f39',
        700: '#08352f',
        green-darker-to-green-800: '#072e29',
        800: '#062b27',
        green-darkest-to-green-900: '#05211e',
        900: '#05211e',
    },
    gold: {
        yellow-lightest-to-gold-50: '#fff2c9',
        50: '#fff5d6',
        100: '#ffebad',
        yellow-lighter-to-gold-200: '#ffe596',
        200: '#ffe085',
        300: '#ffd65c',
        yellow-light-to-gold-300: '#ffdb6f',
        DEFAULT: '#ffcc33',
        500: '#edbd2c',
        yellow-dark-to-gold-600: '#d8ad2d',
        600: '#dbae25',
        700: '#c89f1f',
        800: '#b69018',
        yellow-darker-to-gold-800: '#ae8f30',
        900: '#a48111',
        yellow-darkest-to-gold-900: '#866e26',
    },
    */
    // Delete these after the above replacements are made
    grey: {
        darkest: '#323333',
        darker: '#575959',
        dark: '#949999',
        default: '#babfbf',
        light: '#d9d9d9',
        lighter: '#e6e6e6',
        lightest: '#f2f2f2',
    },
    red: {
        darkest: '#3b0d0c',
        darker: '#621b18',
        dark: '#cc1f1a',
        default: '#e60000',
        light: '#ef5753',
        lighter: '#f9acaa',
        lightest: '#fcebea',
    },
    yellow: {
        darkest: '#866e26',
        darker: '#ae8f30',
        dark: '#d8ad2d',
        default: '#ffcc33',
        light: '#ffdb6f',
        lighter: '#ffe596',
        lightest: '#fff2c9',
    },
    green: {
        darkest: '#05211e',
        darker: '#072e29',
        dark: '#093f39',
        default: '#0c5449',
        light: '#3d7a67',
        lighter: '#71a192',
        lightest: '#acc9c0',
    },
}

const screens = {
    sm: '420px',
    md: '576px',
    lg: '732px',
    xl: '888px',
    xxl: '1044px',
    // xxl-to-2xl: '1044px',
    xxxl: '1200px',
    // xxxl-to-3xl: '1200px',
    mt: '780px', // Adjust this based on the top menu width
    print: {'raw': 'print'},
}

module.exports = {
    theme: {
        colors: colors,
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
            colors: myColors,
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
                'white': '0 7px 0 '+ colors.white +', 0 14px 0 '+ colors.white,
                'grey': '0 7px 0 '+ colors.gray +', 0 14px 0 '+ colors.gray,
            },
            opacity: {
                '20': '.20',
                '65': '.65',
            },
            inset: {
                '4': '1rem',
            },
        },
    },
    variants: {
        opacity: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
        textDecoration: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
        backgroundColor: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
        textColor: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
        borderColor: ['responsive', 'hover', 'focus', 'active', 'group-hover'],
    },
    plugins: [
        require('glhd-tailwindcss-transitions')(), // https://github.com/glhd/tailwindcss-plugins/
    ],
    purge: false,
}
