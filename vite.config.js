import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/tour-gallery.js', 'resources/js/enquiry-intl-tel.js', 'resources/js/contact-intl-tel.js'],
            refresh: true,
        }),
    ],
});
