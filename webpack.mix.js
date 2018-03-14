const { mix } = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
   .js('resources/assets/js/app-landing.js', 'public/js/app-landing.js')
   .sourceMaps()
   .combine([
       'resources/assets/css/bootstrap.min.css',
       'resources/assets/css/font-awesome.min.css',
       'resources/assets/css/ionicons.min.css',
       'node_modules/admin-lte/dist/css/AdminLTE.min.css',
       'node_modules/admin-lte/dist/css/skins/_all-skins.css',
       'node_modules/icheck/skins/square/blue.css'
   ], 'public/css/all.css')
   .combine([
       'resources/assets/css/bootstrap.min.css',
       'resources/assets/css/pratt_landing.min.css'
   ], 'public/css/all-landing.css')
   // PACKAGE (ADMINLTE-LARAVEL) RESOURCES
   .copy('resources/assets/img/*.*','public/img/')
   //VENDOR RESOURCES
   .copy('node_modules/font-awesome/fonts/*.*','public/fonts/')
   .copy('node_modules/ionicons/dist/fonts/*.*','public/fonts/')
   .copy('node_modules/bootstrap/fonts/*.*','public/fonts/')
   .copy('node_modules/admin-lte/dist/css/skins/*.*','public/css/skins')
   .copy('node_modules/admin-lte/dist/img','public/img')
   .copy('node_modules/admin-lte/plugins','public/plugins')
   .copy('node_modules/icheck/skins/square/blue.png','public/css')
   .copy('node_modules/icheck/skins/square/blue@2x.png','public/css');

if (mix.config.inProduction) {
  mix.version();
  mix.minify();
}

