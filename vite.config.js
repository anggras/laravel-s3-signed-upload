import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
const path = require('path')

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost'
        }
    },
    // root: path.resolve(__dirname, 'resources'),
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
            root: path.resolve(__dirname, 'resources'),
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
    define: {
        global: 'window'
    }
});
