import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                // 'resources/scss/style.scss',
                'resources/css/app.css',
                'resources/css/app.css',
                'resources/css/themes/knowledge-base.css'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
