import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: "0.0.0.0", // Explicitly listen on all interfaces
        port: 5173,
        strictPort: true, // Don't try other ports if 5173 is taken
        hmr: {
            host: "10.20.2.45", // Your local IP
            protocol: "ws",
        },
    },
});
