import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { VitePWA } from 'vite-plugin-pwa';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        VitePWA({
            registerType: 'autoUpdate',
            injectRegister: 'inline',
            workbox: {
                globPatterns: ['**/*.{js,css,html,blade.php}'],
                navigateFallback: '/offline',
            },
            manifest: {
                name: 'Kanboard',
                short_name: 'Kanboard',
                start_url: '/',
                display: 'standalone',
                background_color: '#ffffff',
                theme_color: '#1f2937'
            },
            devOptions: {
                enabled: true
            }
        })
    ],
});
