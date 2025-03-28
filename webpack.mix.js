import mix from 'laravel-mix';

mix.js('resources/js/app.js', 'public/js')
   .postCss('resources/css/app.css', 'public/css', [
      // Thêm plugin PostCSS nếu cần
   ]);