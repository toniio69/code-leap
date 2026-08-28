import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/admin-dashboard.jsx',
                'resources/js/passkeys.js',
            ],
            refresh: true,
        }),
        react(),
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'resources'),
            '~': path.resolve(__dirname, 'resources/views/components'),
            '@components': path.resolve(__dirname, 'resources/views/components'),
            '@js': path.resolve(__dirname, 'resources/js'),
            '@/components': path.resolve(__dirname, 'resources/views/components'),
            'resources/css/utils.js': path.resolve(__dirname, 'resources/css/utils.js'),
        },
    },
});