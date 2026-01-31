/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Filament/**/*.php",
        "./app/Livewire/**/*.php",
        "./vendor/filament/**/*.blade.php",
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                mud: '#3d2b1f',
                dirt: '#d4a373',
                warning: '#ff6b00',
                brand: {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    500: '#f97316', // Orange-500
                    600: '#ea580c', // Orange-600
                    700: '#c2410c', // Orange-700
                },
            },
            fontFamily: {
                stencil: ['"Black Ops One"', 'system-ui'],
                rugged: ['"Russo One"', 'sans-serif'],
                sans: ['"Space Grotesk"', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
}
