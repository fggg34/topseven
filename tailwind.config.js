import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                serif: ['Source Serif 4', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                brand: {
                    light: '#78a032',
                    DEFAULT: '#5a7825',
                    dark: '#3c5019',
                    headline: '#0f1406',
                    btn: '#87b438',
                    'btn-hover': '#78a032',
                    footer: '#1A1A19',
                    'footer-border': '#3D5016',
                },
                lime: {
                    50: '#f5f9ed',
                    100: '#e8f2d9',
                    200: '#d4e6b8',
                    300: '#b8d68d',
                    400: '#96c055',
                    500: '#78a032',
                    600: '#5a7825',
                    700: '#3c5019',
                    800: '#2a3812',
                    900: '#0f1406',
                    950: '#0a0d04',
                },
            },
        },
    },

    plugins: [forms],
};
