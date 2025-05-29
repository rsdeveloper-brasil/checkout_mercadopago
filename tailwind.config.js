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
            /**
             * personalizando as cores
             * https://m2.material.io/design/color/the-color-system.html#tools-for-picking-colors
             */
            colors: {
                'primary': {
                    '100': '#feb1dd',
                    '200': '#f87fc2',
                    '300': '#f148a5',
                    '400': '#ec008d',
                    '500': '#ea0075',
                },
                'secondary': {
                    '100': '#e1fedd',
                    '200': '#cdfec8',
                    '300': '#b9fdb1',
                    '400': '#a6fa9d',
                    '500': '#95f78b',
                },
                'tertiary': {
                    '900': '#0e1117',
                    '800': '#282a36',
                }
            }

        },
    },

    plugins: [forms],
};
