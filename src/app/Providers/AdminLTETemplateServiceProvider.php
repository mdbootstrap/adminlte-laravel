<?php

namespace Acacha\AdminLTETemplateLaravel\Providers;

use Acacha\AdminLTETemplateLaravel\Console\AdminLTE;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdminLTETemplateServiceProvider.
 */
class AdminLTETemplateServiceProvider extends ServiceProvider
{
    use AppNamespaceDetectorTrait;

    /**
     * Register the application services.
     */
    public function register()
    {
        if (!defined('ADMINLTETEMPLATE_PATH')) {
            define('ADMINLTETEMPLATE_PATH', realpath(__DIR__.'/../../'));
        }

        if ($this->app->runningInConsole()) {
            $this->commands([AdminLTE::class]);
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

        $this->publishHomeController();
        $this->changeAuthController();
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

            $router->group(['namespace' => $this->getAppNamespace().'Http\Controllers'], function () {
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
            ADMINLTETEMPLATE_PATH.'/resources/assets/less' => base_path('resources/assets/less'),
            ADMINLTETEMPLATE_PATH.'/gulpfile.js' => base_path('gulpfile.js'),

        ], 'adminlte');
    }

    /**
     * Publish public resource assets to Laravel project.
     */
    private function publishPublicAssets()
    {
        $this->publishes([
            ADMINLTETEMPLATE_PATH.'/public/img' => public_path('img'),
            ADMINLTETEMPLATE_PATH.'/public/css' => public_path('css'),
            ADMINLTETEMPLATE_PATH.'/public/js' => public_path('js'),
            ADMINLTETEMPLATE_PATH.'/public/plugins' => public_path('plugins'),
            ADMINLTETEMPLATE_PATH.'/public/fonts' => public_path('fonts'),
        ], 'adminlte');
    }

    /**
     * Publish Home Controller.
     */
    private function publishHomeController()
    {
        $this->publishes([
            ADMINLTETEMPLATE_PATH.'/app/stubs/HomeController.stub' => app_path('Http/Controllers/HomeController.php'),
        ], 'adminlte');
    }

    /**
     * Change default Laravel AuthController.
     */
    private function changeAuthController()
    {
        $this->publishes([
            ADMINLTETEMPLATE_PATH.'/app/stubs/AuthController.stub' => app_path('Http/Controllers/Auth/AuthController.php'),
        ], 'adminlte');
    }
}
