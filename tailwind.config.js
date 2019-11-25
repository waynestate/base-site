let colors = {
    transparent: 'transparent',
    black: '#181a19',
    white: '#fff',
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

screens = {
    sm: '420px',
    md: '576px',
    lg: '732px',
    xl: '888px',
    xxl: '1044px',
    xxxl: '1200px',
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
            maxWidth: {
                'half': '50%',
                'screen-xxxl': screens.xxxl,
            },
            padding: {
                '3/4' : '75%',
                '16/9': '56.35%',
                'hero' : '36.3%',
                'full' : '100%',
                'portrait' : '133%',
            },
            spacing: {
                '14' : '3.5rem',
            },
            margin: {
                '17' : '4.25rem',
                '19' : '4.75rem',
            },
            minHeight: {
                'hero': '36.3vw',
            },
            boxShadow: {
                'white': '0 7px 0 '+ colors.white +', 0 14px 0 '+ colors.white,
                'grey': '0 7px 0 '+ colors.grey +', 0 14px 0 '+ colors.grey,
            },
            opacity: {
                '20' : '.20',
                '65' : '.65',
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
}
