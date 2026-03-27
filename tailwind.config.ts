import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    DarkMode: 'class',
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.tsx',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
                principal: ['"Stack Sans Headline"', 'sans-serif'],
                cursiva:['Pacifico', 'cursive'],
            },
             colors: {
                negro: '#000000',
                blanco: '#ffffff',

                amarillo: '#f39c12',
                amarilloOscuro: '#704304',

                verde: '#2ecc71',

                gris: '#e9e9e9',
                grisMedio: '#bbbbbb',
                grisOscuro: '#333333',

                rojo: '#e74c3c',
                rojoOscuro: '#660101',

                azul: '#00366b',
                azulClaro: '#0066cc',
                azulOscuro: '#011427',
                azulNegro: '#000f1f',

                moradoOscuro: '#1e1e2b',
                azulGris: '#19242c',
            },
        },
    },

    plugins: [forms],
};
