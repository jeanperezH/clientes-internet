const mix = require('laravel-mix');


mix.scripts([
    //'resources/assets/carpeta/js/jquery-3.4.1.min.js',
    //'resources/assets/carpeta/js/popper.min.js',
    
 ], 'public/js/estilos.js')
.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
