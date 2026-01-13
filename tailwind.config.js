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
            // --- TAMBAHAN WARNA TEMA BARU ---
            colors: {
                'bengkel-dark': '#0f172a',   // Slate 900 (Background Gelap)
                'bengkel-blue': '#1e40af',   // Blue 800 (Navbar/Primary)
                'bengkel-light': '#f1f5f9',  // Slate 100 (Background Halaman)
                'bengkel-accent': '#f59e0b', // Amber 500 (Tombol/Aksen)
            }
            // --------------------------------
        },
    },

    plugins: [forms],
};