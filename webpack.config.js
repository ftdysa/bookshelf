const Encore = require('@symfony/webpack-encore');
const Dotenv = require('dotenv-webpack');

Encore
// the project directory where all compiled assets will be stored
    .setOutputPath('public/build/')

    // the public path used by the web server to access the previous directory
    .setPublicPath('/build')

    // will create public/build/app.js and public/build/app.css
    .addEntry('app', ['./assets/js/main.js'])
    .addEntry('createreadlog', './assets/js/createreadlog.js')

    // allow sass/scss files to be processed
    .enableSassLoader()

    .enableSourceMaps(!Encore.isProduction())

    // empty the outputPath dir before each build
    .cleanupOutputBeforeBuild()

    // show OS notifications when builds finish/fail
    .enableBuildNotifications()

    .autoProvidejQuery()
    .createSharedEntry('vendor', [
        'jquery',
        'selectize'
    ])

    // create hashed filenames (e.g. app.abc123.css)
    .enableVersioning(!Encore.isProduction())

    .addPlugin(new Dotenv())
;

// export the final configuration
module.exports = Encore.getWebpackConfig();
