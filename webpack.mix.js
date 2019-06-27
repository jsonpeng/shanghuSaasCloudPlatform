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

mix.js('resources/assets/js/default/main.js', 'public/js/default/main.js')
   .less('resources/assets/less/default/base.less', 'public/css/default/app.css');

/*主题*/
// mix.js('resources/assets/js/social/main.js', 'public/js/social/main.js')
//     .less('resources/assets/less/social/base.less', 'public/css/social/app.css');