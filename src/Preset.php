<?php
namespace AustenCam\Preset;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Console\Presets\Preset as BasePreset;

class Preset extends BasePreset
{
    public static function install()
    {
        static::ensureComponentDirectoryExists();
        static::updatePackages();
        static::updateWebpackConfig();
        static::updateViews();
        static::updateCss();
        static::updateJavascript();
        static::updateGitignore();
        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param  array  $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'laravel-mix-purgecss' => '^3.0.0',
            'postcss-import' => '^12.0.0',
            'postcss-nesting' => '^7.0.0',
            'tailwindcss' => '>=0.6.6',
        ] + array_except($packages, [
            'bootstrap',
            'jquery',
            'popper.js',
        ]);
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfig()
    {
        copy(__DIR__ . '/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    /**
     * Update the CSS files and remove extra scss stuff
     */
    protected static function updateCss()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(resource_path('sass'));
            $files->delete(public_path('css/app.css'));

            if (! $files->isDirectory($directory = resource_path('css'))) {
                $files->makeDirectory($directory, 0755, true);
            }
            $files->copy(__DIR__ . '/stubs/resources/css/app.css', resource_path('css/app.css'));
        });
    }

    /**
     * Copy in our preset's Javascript files
     */
    protected static function updateJavascript()
    {
        tap(new Filesystem, function ($files) {
            $files->delete(public_path('js/app.js'));
            $files->copy(__DIR__ . '/stubs/resources/js/bootstrap.js', resource_path('js/bootstrap.js'));
        });
    }

    /**
     * Update the blade views in the application
     */
    protected static function updateViews()
    {
        tap(new Filesystem, function ($files) {
            $files->delete(resource_path('views/welcome.blade.php'));
            $files->copyDirectory(__DIR__.'/stubs/resources/views', resource_path('views'));
        });
    }

    /**
     * Update the default .gitignore file
     */
    protected static function updateGitignore()
    {
        copy(__DIR__ . '/stubs/new-gitignore', base_path('.gitignore'));
    }
}