/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Http/**/*.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            },
            colors: {
                primary: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    500: '#0ea5e9',
                    600: '#0284c7', // sky-600
                    700: '#0369a1',
                },
                cta: {
                    500: '#f97316', // orange-500
                    600: '#ea580c', // orange-600
                },
            },
        },
    },
    plugins: [],
};
