import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/assets/css/app.css', // Đường dẫn đến file CSS
                'resources/assets/css/app.js'
            ],
            refresh: true,
        }),
    ],
});