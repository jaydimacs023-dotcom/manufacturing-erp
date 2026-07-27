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
                'primary-container': '#02462f',
                'primary-dark': '#002e1d',
                'brand-bg': '#f4fbf5',
                'surface-low': '#eef5f0',
                'surface-high': '#e2eae4',
                'surface-highest': '#dde4df',
                'surface-lowest': '#ffffff',
                'text-on-surface': '#161d1a',
                'text-variant': '#404943',
                'accent-dim': '#97d3b4',
                'sidebar-bg': '#082c22',
                'error-container': '#ffdad6',
                'error-dark': '#ba1a1a',
                'outline-variant': '#c0c9c1',
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                headline: ['Figtree', ...defaultTheme.fontFamily.sans],
                body: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
