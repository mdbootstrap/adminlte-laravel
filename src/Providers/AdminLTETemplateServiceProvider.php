<?php

namespace Acacha\AdminLTETemplateLaravel\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Creativeorange\Gravatar\Facades\Gravatar;
use Acacha\AdminLTETemplateLaravel\Facades\AdminLTE;
use Creativeorange\Gravatar\GravatarServiceProvider;
use Acacha\AdminLTETemplateLaravel\Http\Middleware\GuestUser;

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
            $this->commands([\Acacha\AdminLTETemplateLaravel\Console\Username::class]);
        }

        $this->app->bind('AdminLTE', function () {
            return new \Acacha\AdminLTETemplateLaravel\AdminLTE();
        });

        if (config('adminlte.gravatar', true)) {
            $this->registerGravatarServiceProvider();
        }

        if (config('auth.providers.users.field', 'email') === 'username'  &&
            config('adminlte.add_nullable_username', true)) {
            $this->loadMigrationsFrom(ADMINLTETEMPLATE_PATH .'/database/migrations/username_login');
        }
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
    public function boot(Router $router)
    {
        $router->pushMiddlewareToGroup('web', GuestUser::class);

        //Publish
        $this->publishHomeController();
        $this->changeRegisterController();
        $this->changeLoginController();
        $this->changeForgotPasswordController();
        $this->publishNoGuestForgotPasswordController();
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
        $this->publishDusk();
        $this->publishDatabaseConfig();

        $this->enableSpatieMenu();
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
     * Publish no guest forgot password Controller.
     */
    private function publishNoGuestForgotPasswordController()
    {
        $this->publishes(AdminLTE::noGuestForgotPasswordController(), 'adminlte');
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
     * Publish dusk tests files.
     */
    private function publishDusk()
    {
        $this->publishDuskEnvironment();
    }

    /**
     * Publish dusk environment files.
     */
    private function publishDuskEnvironment()
    {
        $this->publishes(AdminLTE::duskEnvironment(), 'adminlte');
    }

    /**
     * Publish database config files.
     */
    private function publishDatabaseConfig()
    {
        $this->publishes(AdminLTE::databaseConfig(), 'adminlte');
    }

    /**
     * Enable (if active) spatie menu.
     */
    private function enableSpatieMenu()
    {
        if ($this->app->getProvider('Spatie\Menu\Laravel\MenuServiceProvider')) {
            require config_path('menu.php');
        }
    }
}
