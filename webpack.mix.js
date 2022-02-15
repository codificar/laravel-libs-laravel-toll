let mix = require('laravel-mix');

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

mix.js('src/resources/assets/js/toll.vue.js', 'public/js').vue();

mix.copy('public/js/toll.vue.js', '../../../public/vendor/codificar/toll/toll.vue.js');
