import { defineConfig } from 'vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: [
                ...refreshPaths,
                'app/Http/Livewire/**',
            ],
        }),
    ],
    server: {
        hmr: {
            protocol: 'wss',
            host: 'laravel-livewire.ddev.site',
        },
        // respond to all network requests
        // host: '0.0.0.0',
        // "Set to true to exit if port is already in use, instead of automatically try the next available port."
        strictPort: true,
        // port: 5173
    },
});
