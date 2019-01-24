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

// Fix for the Jquery problem
 mix.webpackConfig(webpack => {
     return {
         plugins: [
             new webpack.ProvidePlugin({
                 $: 'jquery',
                 jQuery: 'jquery',
                 'window.jQuery': 'jquery',
             })
         ]
     };
 });

/* JS (generate: manifest.js, vendor.js, app.js)*/
/*  jQuery first, then Popper.js (tooltips), then Bootstrap JS */
mix.js('resources/js/app.js', 'public/js')
   .extract([
        'jquery',
        'popper.js', //((positioning engine for tooltips))
        //'bootstrap'
    ]);


/* CSS - Vendor - OK*/
/*mix.styles([
   'node_modules/bootstrap/dist/css/bootstrap.css',
   'node_modules/jquery-ui/themes/base/core.css',
   'node_modules/jquery-ui/themes/base/accordion.css',
   'node_modules/smartmenus/dist/addons/bootstrap-4/jquery.smartmenus.bootstrap-4.css',
   'node_modules/smartmenus/dist/css/sm-core-css.css',
   'node_modules/slick-carousel/slick/slick.css',
   'node_modules/slick-carousel/slick/slick-theme.css',
   'node_modules/@fancyapps/fancybox/dist/jquery.fancybox.css',
   'node_modules/bootstrap-select/dist/css/bootstrap-select.css',
   'node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css',
   'node_modules/bootstrap-timepicker/css/bootstrap-timepicker.css',
   'node_modules/cookieconsent/build/cookieconsent.min.css',
], 'public/css/vendor.css');*/

/* CSS - Custom - OK */
mix.sass('resources/sass/app.scss', 'public/css');
