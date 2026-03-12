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
            },
        },
        // colors: {
        //     primary: {
        //         DEFAULT: '#136566',
        //         dark: '#0f4f50',
        //         light: '#1b7a7b',
        //     },
        //     surface: '#0e4a4b',
        //     muted: '#6b7280',
        //     success: '#16a34a',
        //     danger: '#dc2626',
        //     warning: '#f59e0b',
        // },
    },

    plugins: [forms],
    transitionProperty: {
        'width': 'width'
    }
};
