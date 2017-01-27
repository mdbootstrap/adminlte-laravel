<?php

namespace Acacha\AdminLTETemplateLaravel\Providers;

use Acacha\AdminLTETemplateLaravel\Facades\AdminLTE;
use Acacha\User\Providers\GuestUserServiceProvider;
use Creativeorange\Gravatar\Facades\Gravatar;
use Creativeorange\Gravatar\GravatarServiceProvider;
use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Support\ServiceProvider;

/**
 * Class AdminLTETemplateServiceProvider.
 */
class AdminLTETemplateServiceProvider extends ServiceProvider
{
    use DetectsApplicationNamespace;

    /**
     * Register the application services.
     */
    public function register()
    {
        if (!defined('ADMINLTETEMPLATE_PATH')) {
            define('ADMINLTETEMPLATE_PATH', realpath(__DIR__.'/../../'));
        }

        if ($this->app->runningInConsole()) {
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\PublishAdminLTE::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\PublishAdminLTEAlt::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\PublishAdminLTESidebar::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\PublishAdminLTESidebarAlt::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeAdminUserSeeder::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\AdminLTEAdmin::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\AdminLTEAdminAlt::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeView::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\AdminLTEMenu::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\AdminLTEMenuAlt::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeRoute::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeMenu::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeV::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeVC::class]);
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\MakeMVC::class]);
        }

        $this->app->bind('AdminLTE', function () {
            return new \Acacha\AdminLTETemplateLaravel\AdminLTE();
        });

        if (config('adminlte.gravatar', true)) {
            $this->registerGravatarServiceProvider();
        }

        if (config('adminlte.guestuser', true)) {
            $this->registerGuestUserProvider();
        }
    }

    /**
     * Register Guest User Provider.
     */
    protected function registerGuestUserProvider()
    {
        $this->app->register(GuestUserServiceProvider::class);
    }

    /**
     * Register Gravatar Service Provider.
     */
    protected function registerGravatarServiceProvider()
    {
        $this->app->register(GravatarServiceProvider::class);
        if (!class_exists('Gravatar')) {
            class_alias(Gravatar::class, 'Gravatar');
        }
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->defineRoutes();
        $this->publishHomeController();
        $this->changeRegisterController();
        $this->changeLoginController();
        $this->changeForgotPasswordController();
        $this->changeResetPasswordController();
        $this->publishPublicAssets();
        $this->publishViews();
        $this->publishResourceAssets();
        $this->publishTests();
        $this->publishLanguages();
        $this->publishGravatar();
        $this->publishConfig();
        $this->publishWebRoutes();
        $this->publishApiRoutes();
        $this->enableSpatieMenu();
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
        $this->publishes(AdminLTE::homeController(), 'adminlte');
    }

    /**
     * Change default Laravel RegisterController.
     */
    private function changeRegisterController()
    {
        $this->publishes(AdminLTE::registerController(), 'adminlte');
    }

    /**
     * Change default Laravel LoginController.
     */
    private function changeLoginController()
    {
        $this->publishes(AdminLTE::loginController(), 'adminlte');
    }

    /**
     * Change default Laravel forgot password Controller.
     */
    private function changeForgotPasswordController()
    {
        $this->publishes(AdminLTE::forgotPasswordController(), 'adminlte');
    }

    /**
     * Change default Laravel reset password Controller.
     */
    private function changeResetPasswordController()
    {
        $this->publishes(AdminLTE::resetPasswordController(), 'adminlte');
    }

    /**
     * Publish public resource assets to Laravel project.
     */
    private function publishPublicAssets()
    {
        $this->publishes(AdminLTE::publicAssets(), 'adminlte');
    }

    /**
     * Publish package views to Laravel project.
     */
    private function publishViews()
    {
        $this->loadViewsFrom(ADMINLTETEMPLATE_PATH.'/resources/views/', 'adminlte');

        $this->publishes(AdminLTE::views(), 'adminlte');
    }

    /**
     * Publish package resource assets to Laravel project.
     */
    private function publishResourceAssets()
    {
        $this->publishes(AdminLTE::resourceAssets(), 'adminlte');
    }

    /**
     * Publish package tests to Laravel project.
     */
    private function publishTests()
    {
        $this->publishes(AdminLTE::tests(), 'adminlte');
    }

    /**
     * Publish package language to Laravel project.
     */
    private function publishLanguages()
    {
        $this->loadTranslationsFrom(ADMINLTETEMPLATE_PATH.'/resources/lang/', 'adminlte_lang');

        $this->publishes(AdminLTE::languages(), 'adminlte_lang');
    }

    /**
     * Publish config Gravatar file using group.
     */
    private function publishGravatar()
    {
        $this->publishes(AdminLTE::gravatar(), 'adminlte');
    }

    /**
     * Publish adminlte package config.
     */
    private function publishConfig()
    {
        $this->publishes(AdminLTE::config(), 'adminlte');
    }

    /**
     * Publish routes/web.php file.
     */
    private function publishWebRoutes()
    {
        $this->publishes(AdminLTE::webroutes(), 'adminlte');
    }

    /**
     * Publish routes/api.php file.
     */
    private function publishApiRoutes()
    {
        $this->publishes(AdminLTE::apiroutes(), 'adminlte');
    }

    /**
     * Enable (if active) spatie menu.
     */
    protected function enableSpatieMenu()
    {
        if ($this->app->getProvider('Spatie\Menu\Laravel\MenuServiceProvider')) {
            require config_path('menu.php');
        }
    }
}
