const mix = require('laravel-mix');

mix.ts('resources/ts/custom.ts', 'public/js')
   .setPublicPath('public')
   .version();
