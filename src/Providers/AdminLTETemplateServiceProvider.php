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

        $this->app->bind('acacha/AdminLTE', function () {
            return new \Acacha\AdminLTETemplateLaravel\AdminLTE();
        });
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
     * Publish Home Controller.
     */
    private function publishHomeController()
    {
        $this->publishes(acacha/AdminLTE::homeController(), 'adminlte');
    }

    /**
     * Change default Laravel AuthController.
     */
    private function changeAuthController()
    {
        $this->publishes(acacha/AdminLTE::authController(), 'adminlte');
    }

    /**
     * Publish public resource assets to Laravel project.
     */
    private function publishPublicAssets()
    {
        $this->publishes(acacha/AdminLTE::publicAssets(), 'adminlte');
    }

    /**
     * Publish package views to Laravel project.
     */
    private function publishViews()
    {
        $this->loadViewsFrom(ADMINLTETEMPLATE_PATH.'/resources/views/', 'adminlte');

        $this->publishes(acacha/AdminLTE::views(), 'adminlte');
    }

    /**
     * Publish package resource assets to Laravel project.
     */
    private function publishResourceAssets()
    {
        $this->publishes(acacha/AdminLTE::resourceAssets(), 'adminlte');
    }
}
