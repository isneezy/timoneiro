module.exports = {
    theme: {
        colors: {
            gray: {
                100: '#f7fafc',
                200: '#edf2f7',
                300: '#e2e8f0',
                400: '#cbd5e0',
                500: '#a0aec0',
                600: '#718096',
                700: '#4a5568',
                800: '#2d3748',
                900: '#1a202c',
            },
            white: '#fff',
            primary: 'var(--color-primary)',
            secondary: 'var(--color-secondary)',
            success: 'var(--color-success)',
            danger: 'var(--color-danger)',
            warning: 'var(--color-warning)',
            info: 'var(--color-info)',
            light: 'var(--color-light)',
            dark: 'var(--color-dark)'
        },
        fontFamily: {
            body: 'var(--font-family-body)'
        },
        extend: {
            spacing: theme => ({
                'top-bar-h': '4rem'
            }),
            maxHeight: theme => ({
                'top-bar-h': theme('spacing.top-bar-h')
            }),
            minWidth: theme => ({
                8: theme('spacing.8')
            })
        },
    },
    variants: {},
    plugins: []
}
