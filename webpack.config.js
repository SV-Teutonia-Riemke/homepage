const Encore = require('@symfony/webpack-encore');
// const OfflinePlugin = require('@lcdp/offline-plugin');
const MonacoWebpackPlugin = require('monaco-editor-webpack-plugin');

const imageCacheBuster = (Math.random() + 1).toString(36).substring(7);
const manifestOptions = {
    name: 'SV Teutonia Riemke', // Erscheint unter anderem im App-Startbildschirm auf Android.
    short_name: 'SVT', // App-Titel z.b. im Android App-Drawer.
    description: 'App des SV Teutonia Riemke',

    // Einfärbungen der Browserleiste.
    theme_color: '#009146',
    background_color: '#009146',

    display: 'standalone', // Browser stellt im App-Modus nur einen Reload und Vor/Zurückbutton bereit.
    prefer_related_applications: false, // Legt fest das keine alternativ Apps zur Installation angeboten werden sollen.
    start_url: '/', // Diese URL wird beim öffnen der App geladen. Könnte z.b. auch /?pwa=true sein falls man es tracken möchte.

    icons: [{
        src: '/build/img/logo.' + imageCacheBuster + '.png',
        sizes: '192x192',
        type: 'image/png'
    }, {
        src: '/build/img/logo.' + imageCacheBuster + '.png',
        sizes: '512x512',
        type: 'image/png'
    }]
};

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/app.ts')
    .addEntry('admin', './assets/admin.ts')
    .addEntry('monaco', './assets/monaco.js')

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]',
        pattern: /\.(png|jpg|jpeg|gif|ico|svg)$/
    })

    .copyFiles({
        from: './assets/images',
        to: 'img/[path][name].' + imageCacheBuster + '.[ext]',
        pattern: /\.(png|jpg|jpeg|gif|ico|svg)$/
    })

    .copyFiles({
        from: './assets/documents',
        to: 'documents/[path][name].[hash:8].[ext]',
    })

    .copyFiles({
        from: './assets/ckeditor/plugins',
        to: 'ckeditor/plugins/[path][name].[ext]',
    })

    // Manifest hinzufügen.
    .configureManifestPlugin((options) => {
        options.seed = manifestOptions;
    })

    // enables the Symfony UX Stimulus bridge (used in assets/bootstrap.js)
    .enableStimulusBridge('./assets/controllers.json')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning()

    .configureBabel((config) => {
    })

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    .enableTypeScriptLoader()

    // uncomment if you use React
    //.enableReactPreset()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    .enableIntegrityHashes(Encore.isProduction())

    .addPlugin(
        new MonacoWebpackPlugin()
    )

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()
;


const webpackConfig = Encore.getWebpackConfig();

module.exports = webpackConfig;
