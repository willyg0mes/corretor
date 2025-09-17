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
            colors: {
                primary: {
                    50: '#f0f5ed',
                    100: '#dbe5d1',
                    200: '#b9cca7',
                    300: '#97b37d',
                    400: '#7ba85a',
                    500: '#679047', // Base
                    600: '#4d6b35',
                    700: '#3d5428',
                    800: '#2d3e1c',
                    900: '#1d2812',
                },
                secondary: {
                    50: '#f0fafb',
                    100: '#d9f0f2',
                    200: '#b9e4e7',
                    300: '#9bd1d5',
                    400: '#7ac2c7', // Base
                    500: '#5da8ac',
                    600: '#3F9196',
                    700: '#2d6b6f',
                    800: '#1e474a',
                    900: '#0f2325',
                },
                accent: {
                    50: '#f7f7e8',
                    100: '#ececc2',
                    200: '#dfe086',
                    300: '#d2d44a',
                    400: '#b2b72a',
                    500: '#909720', // Base
                    600: '#6b7017',
                    700: '#525812',
                    800: '#3a400d',
                    900: '#212607',
                },
            },
            animation: {
                'fade-in': 'fadeIn 0.5s ease-in-out',
                'slide-up': 'slideUp 0.6s ease-out',
                'bounce-subtle': 'bounceSubtle 2s infinite',
                'shimmer': 'shimmer 1.5s infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                bounceSubtle: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-5px)' },
                },
                shimmer: {
                    '0%': { 'background-position': '-200% 0' },
                    '100%': { 'background-position': '200% 0' },
                },
            },
            boxShadow: {
                'soft': '0 2px 15px rgba(0, 0, 0, 0.08)',
                'medium': '0 4px 25px rgba(0, 0, 0, 0.12)',
                'large': '0 8px 40px rgba(0, 0, 0, 0.16)',
            },
        },
    },

    plugins: [forms],
};
