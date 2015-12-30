<?php

namespace Acacha\AdminLTETemplateLaravel\app\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AdminLTETemplateServiceProvider.
 */
class AdminLTETemplateServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        if (!defined('ADMINLTETEMPLATE_PATH')) {
            define('ADMINLTETEMPLATE_PATH', realpath(__DIR__.'/../../'));
        }
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->defineRoutes();
        });

        $this->publishPublicAssets();
        $this->publishViews();
        $this->publishResourceAssets();
    }

    /**
     * Define the AdminLTETemplate routes.
     */
    protected function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $router = app('router');

            $router->group(['namespace' => 'Acacha\AdminLTETemplateLaravel\Http\Controllers'], function ($router) {
                require __DIR__.'/../Http/routes.php';
            });
        }
    }

    /**
     * Publish package views to Laravel project.
     */
    private function publishViews()
    {
        $this->loadViewsFrom(ADMINLTETEMPLATE_PATH.'/resources/views/', 'adminlte');

        $this->publishes([
            ADMINLTETEMPLATE_PATH.'/resources/views/auth' => base_path('resources/views/auth'),
            //ADMINLTETEMPLATE_PATH . '/resources/views/emails' => base_path('resources/views/emails'), TODO
            ADMINLTETEMPLATE_PATH.'/resources/views/errors' => base_path('resources/views/errors'),
            ADMINLTETEMPLATE_PATH.'/resources/views/layouts' => base_path('resources/views/layouts'),
            ADMINLTETEMPLATE_PATH.'/resources/views/home.blade.php' => base_path('resources/views/home.blade.php'),
            ADMINLTETEMPLATE_PATH.'/resources/views/welcome.blade.php' => base_path('resources/views/welcome.blade.php'),
        ], 'adminlte');
    }

    /**
     * Publish package resource assets to Laravel project.
     */
    private function publishResourceAssets()
    {
        $this->publishes([
            dirname(__FILE__).'/../../resources/assets/less' => base_path('resources/assets/less'),
            dirname(__FILE__).'/../../gulpfile.js' => base_path('gulpfile.js'),

        ], 'adminlte');
    }

    /**
     * Publish public resource assets to Laravel project.
     */
    private function publishPublicAssets()
    {
        $this->publishes([
            dirname(__FILE__).'/../../public/img' => public_path('img'),
            dirname(__FILE__).'/../../public/css' => public_path('css'),
            dirname(__FILE__).'/../../public/js' => public_path('js'),
            dirname(__FILE__).'/../../public/plugins' => public_path('plugins'),
            dirname(__FILE__).'/../../public/fonts' => public_path('fonts'),
        ], 'adminlte');
    }
}
