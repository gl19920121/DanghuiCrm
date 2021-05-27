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

mix
  .js('resources/js/app.js', 'public/js')
  .js('resources/js/my.js', 'public/js')
  .sass('resources/sass/app.scss', 'public/css/scss.css')
  .less('resources/less/app.less', 'public/css/less.css')
  .sass('resources/sass/common.scss', 'public/css/common.css')
  .sass('resources/sass/resume/app.scss', 'public/css/resume.css')
;

mix.styles([
    'public/css/scss.css',
    'public/css/less.css'
], 'public/css/app.css');

mix.styles([
    'public/css/common.css',
    'public/css/resume.css'
], 'public/css/my.css');
