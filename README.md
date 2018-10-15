# Laravel Preset 
## Installation 
Run this command to add the preset to your project:
```sh
composer require austenc/preset --dev    
```

Run this command to install the preset
```sh
php artisan preset austencam
```

## What It Does
- Removes Bootstrap and jQuery
- Removes minified `.js` and `.css` files from version control
- Installs [Tailwind CSS](https://tailwindcss.com), postcss-import and postcss-nesting
- Adds a default `app` blade template layout