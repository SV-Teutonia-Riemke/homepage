import {defineConfig} from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import monacoEditorPlugin from 'vite-plugin-monaco-editor';

export default defineConfig(({mode}) => {
    const isDevelopment = mode === "development";

    return {
        plugins: [
            symfonyPlugin({
                stimulus: true,
            }),
            monacoEditorPlugin([]),
        ],
        build: {
            assetsInlineLimit: 0,
            outputDir: "public/build",
            manifest: true,
            sourcemap: isDevelopment,
            emptyOutDir: true,
            rollupOptions: {
                input: {
                    app: "./assets/app.ts",
                    admin: "./assets/admin.ts",
                    monaco: "./assets/monaco.js"
                },
            }
        },
    }
});
