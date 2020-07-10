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

mix.js('resources/js/app.js', 'public/js') //js编译的路径
    .sass('resources/sass/app.scss', 'public/css').version() //css编译的路径；  version()方法：只要文件修改，哈希值就会变，提醒客户端需要重新加载文件，避免浏览器静态文件缓存造成页面不刷新，无法测试页面样式改变
    .sass('resources/sass/home.scss', 'public/css').version(); //需先编译文件才能在前端使用{{  mix('css/home.css') }}编码方法
