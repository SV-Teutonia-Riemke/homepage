import {defineConfig} from "vite";
import symfonyPlugin from "vite-plugin-symfony";
import monacoEditorPlugin from 'vite-plugin-monaco-editor';
import {VitePWA} from 'vite-plugin-pwa';

export default defineConfig(({mode}) => {
    const isDevelopment = mode === "development";

    return {
        plugins: [
            symfonyPlugin({
                stimulus: true,
            }),
            monacoEditorPlugin([]),
            VitePWA({
                injectRegister: 'auto',
                includeAssets: [
                    './assets/images/apple-touch-icon.png',
                    './assets/images/logo.png',
                ],
                manifest: {
                    name: 'SV Teutonia Riemke',
                    short_name: 'SVT',
                    description: 'App des SV Teutonia Riemke',
                    theme_color: '#009146',
                    icons: [
                        {
                            src: './assets/images/logo.png',
                            sizes: '192x192',
                            type: 'image/png'
                        }, {
                            src: './assets/images/logo.png',
                            sizes: '512x512',
                            type: 'image/png'
                        }
                    ]
                }
            })
        ],
        build: {
            assetsInlineLimit: 0,
            outputDir: "public/build",
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
