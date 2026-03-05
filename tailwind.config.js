import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    DEFAULT: '#F43F5E', // Rose 500
                    hover: '#E11D48', // Rose 600
                },
                accent: {
                    DEFAULT: '#10B981', // Emerald 500 for category tags
                },
                dark: {
                    bg: '#000000', // Very dark for main background
                    surface: '#111111', // Slightly lighter for cards/sidebar
                    border: '#222222',
                }
            }
        },
    },

    plugins: [forms],
};
