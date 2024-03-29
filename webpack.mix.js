const mix = require('laravel-mix');
require('laravel-mix-tailwind');

require('laravel-mix-purgecss');
require('laravel-mix-bundle-analyzer');

if (mix.isWatching()) {
    mix.bundleAnalyzer();
}

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

mix
    .sass('resources/scss/tailwind.scss', 'public/css/app.css') 
    .js('resources/js/app.js', 'public/js')    
    .tailwind('tailwind.config.js')
    .purgeCss()   
    .browserSync('http://linoffery.test/');

if (mix.inProduction()) {
    mix.version();
}
