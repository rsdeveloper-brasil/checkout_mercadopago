import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    /**
     * Usar server em caso do wsl do windows
     * sail npm run dev (para rodar em desenvolvmento)
     */
    server: {
        hmr: {
            host: "localhost"
        }
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
});
