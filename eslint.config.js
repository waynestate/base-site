const js = require('@eslint/js');

module.exports = [
    // Apply to JavaScript files
    {
        files: ['**/*.js'],
        languageOptions: {
            ecmaVersion: 'latest',
            sourceType: 'module',
            globals: {
                // Browser globals
                window: 'readonly',
            document: 'readonly',
                console: 'readonly',
                // AMD globals
                define: 'readonly',
                require: 'readonly',
                module: 'readonly',
                exports: 'readonly',
                // Node.js globals (for webpack config files)
                process: 'readonly',
                __dirname: 'readonly',
                __filename: 'readonly',
                Buffer: 'readonly',
                global: 'readonly'
            }
        },
        rules: {
            ...js.configs.recommended.rules,
            'no-console': 'error',
            'no-undef': 'off'
        }
    },
    // Ignore node_modules and other build artifacts
    {
        ignores: [
            'node_modules/**',
            'vendor/**',
            'public/**',
            'storage/**',
            'bootstrap/cache/**'
        ]
    }
];
