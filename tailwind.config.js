let colors = {
    transparent: 'transparent',

    black: '#181a19',
    white: '#fff',

    'grey-darkest': '#323333',
    'grey-darker': '#575959',
    'grey-dark': '#949999',
    'grey': '#babfbf',
    'grey-light': '#d9d9d9',
    'grey-lighter': '#e6e6e6',
    'grey-lightest': '#f2f2f2',

    'red-darkest': '#3b0d0c',
    'red-darker': '#621b18',
    'red-dark': '#cc1f1a',
    'red': '#e60000',
    'red-light': '#ef5753',
    'red-lighter': '#f9acaa',
    'red-lightest': '#fcebea',

    'yellow-darkest': '#866e26',
    'yellow-darker': '#ae8f30',
    'yellow-dark': '#d8ad2d',
    'yellow': '#ffcc33',
    'yellow-light': '#ffdb6f',
    'yellow-lighter': '#ffe596',
    'yellow-lightest': '#fff2c9',

    'green-darkest': '#05211e',
    'green-darker': '#072e29',
    'green-dark': '#093f39',
    'green': '#0c5449',
    'green-light': '#3d7a67',
    'green-lighter': '#71a192',
    'green-lightest': '#acc9c0',
}

screens = {
    'sm': '420px',
    'md': '576px',
    'lg': '732px',
    'xl': '888px',
    'xxl': '1044px',
    'xxxl': '1200px',
    'mt': '780px', // Adjust this based on the top menu width
    'print': {'raw': 'print'},
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
                half: '50%',
                'screen-xxxl': screens['xxxl'],
            },
            spacing: {
                '3/4' : '75%',
                '16/9': '56.35%',
                'hero' : '36.3%',
                'full' : '100%',
                'portrait' : '133%',
            },
            boxShadow: {
                'white': '0 7px 0 '+ colors['white'] +', 0 14px 0 '+ colors['white'],
                'grey': '0 7px 0 '+ colors['grey'] +', 0 14px 0 '+ colors['grey'],
            },
        }
    },
    variants: {},
    plugins: [
        require('glhd-tailwindcss-transitions')(), // https://github.com/glhd/tailwindcss-plugins/
    ],
}
