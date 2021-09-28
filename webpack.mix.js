const mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
const tailwindConfig = require('./tailwind.config');

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
   .js('resources/js/app.js', 'public/js/app.js')
   .sass('resources/sass/app.scss', 'public/css/app.css')
   .options({
     processCssUrls: false,
     postCss: [tailwindcss(tailwindConfig)],
   })
   .sourceMaps();
  
   mix.version();