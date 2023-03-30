const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .js('public/js/main.js', 'public/js')
    .js('public/js/webpush-main.js', 'public/js')
    .js('public/js/webpush-sw.js', 'public/js')
    .postCss('public/css/app-responsive.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/app.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/base.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/common.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/kol.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/layout.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/main.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/responsive.css', 'public/css')
        .options({
            processCssUrls: false
        })
    .postCss('public/css/theme.css', 'public/css')
        .options({
            processCssUrls: false
        });
    // .sass('resources/sass/app.scss', 'public/css');
