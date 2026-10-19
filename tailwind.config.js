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
        colors: {
            'tuwaiq-purple': '#432a80',
            'tuwaiq-purple-light': '#53398f',
            'tuwaiq-orange': '#f2a54a',
            'tuwaiq-teal': '#4fc9b0',
            'tuwaiq-text': '#ece8f6',
        },
        // ... اتركي fontFamily وغيره كما هو
    },
},

    plugins: [forms],
};
