import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import pagination from 'tailwindcss-plugins/pagination';

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
    },

    plugins: [
        forms,
        pagination, // Menambahkan plugin pagination
    ],
};
