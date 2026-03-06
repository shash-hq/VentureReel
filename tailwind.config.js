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
                    DEFAULT: '#F59E0B', // Amber 500
                    hover: '#D97706', // Amber 600
                },
                accent: {
                    DEFAULT: '#10B981', // Emerald 500 for category tags
                },
                base: {
                    cream: '#F5F0E8', // Warm off-white base color
                },
                deep: {
                    charcoal: '#1C1A16', // Deep warm charcoal for dark mode
                },
                dark: {
                    bg: '#1C1A16', // Legacy mapping to charcoal
                    surface: '#26231E', // Slightly lighter for cards/sidebar
                    border: '#332F28',
                }
            }
        },
    },

    plugins: [forms],
};
