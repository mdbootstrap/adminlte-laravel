<?php

namespace Acacha\AdminLTETemplateLaravel;

/**
 * Class AdminLTE.
 */
class AdminLTE
{
    /**
     * Home controller copy path.
     *
     * @return array
     */
    public function homeController()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/src/stubs/HomeController.stub' => app_path('Http/Controllers/HomeController.php'),
        ];
    }

    /**
     * Auth register controller copy path.
     *
     * @return array
     */
    public function registerController()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/src/stubs/RegisterController.stub' =>
                app_path('Http/Controllers/Auth/RegisterController.php'),
        ];
    }

    /**
     * Auth login controller copy path.
     *
     * @return array
     */
    public function loginController()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/src/stubs/LoginController.stub' =>
                app_path('Http/Controllers/Auth/LoginController.php'),
        ];
    }

    /**
     * Auth forgot password controller copy path.
     *
     * @return array
     */
    public function forgotPasswordController()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/src/stubs/ForgotPasswordController.stub' =>
                app_path('Http/Controllers/Auth/ForgotPasswordController.php'),
        ];
    }

    /**
     * Auth reset password controller copy path.
     *
     * @return array
     */
    public function resetPasswordController()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/src/stubs/ResetPasswordController.stub' =>
                app_path('Http/Controllers/Auth/ResetPasswordController.php'),
        ];
    }

    /**
     * Public assets copy path.
     *
     * @return array
     */
    public function publicAssets()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/public/img'     => public_path('img'),
            ADMINLTETEMPLATE_PATH.'/public/css'     => public_path('css'),
            ADMINLTETEMPLATE_PATH.'/public/js'      => public_path('js'),
            ADMINLTETEMPLATE_PATH.'/public/plugins' => public_path('plugins'),
            ADMINLTETEMPLATE_PATH.'/public/fonts'   => public_path('fonts'),
        ];
    }

    /**
     * Only views to overwrite.
     *
     * @return array
     */
    public function viewsToOverwrite()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/views/errors'            =>
                resource_path('views/errors'),
            ADMINLTETEMPLATE_PATH.'/resources/views/welcome.blade.php' =>
                resource_path('views/welcome.blade.php'),
            ADMINLTETEMPLATE_PATH.'/resources/views/layouts/partials/sidebar.blade.php' =>
                resource_path('views/vendor/adminlte/layouts/partials/sidebar.blade.php'),
        ];
    }

    /**
     * Path of sidebar.
     *
     * @return array
     */
    public function sidebarView()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/views/layouts/partials/sidebar.blade.php' =>
                resource_path('views/vendor/adminlte/layouts/partials/sidebar.blade.php'),
        ];
    }

    /**
     * Views copy path.
     *
     * @return array
     */
    public function views()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/views/auth'              =>
                resource_path('views/vendor/adminlte/auth'),
            ADMINLTETEMPLATE_PATH.'/resources/views/auth/emails'       =>
                resource_path('views/vendor/adminlte/auth/emails'),
            ADMINLTETEMPLATE_PATH.'/resources/views/errors'            =>
                resource_path('views/vendor/adminlte/errors'),
            ADMINLTETEMPLATE_PATH.'/resources/views/layouts'           =>
                resource_path('views/vendor/adminlte/layouts'),
            ADMINLTETEMPLATE_PATH.'/resources/views/home.blade.php'    =>
                resource_path('views/vendor/adminlte/home.blade.php'),
            ADMINLTETEMPLATE_PATH.'/resources/views/welcome.blade.php' =>
                resource_path('views/welcome.blade.php'),
        ];
    }

    /**
     * Tests copy path.
     *
     * @return array
     */
    public function tests()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/tests'       => base_path('tests'),
            ADMINLTETEMPLATE_PATH.'/phpunit.xml' => base_path('phpunit.xml'),
        ];
    }

    /**
     * Resource assets copy path.
     *
     * @return array
     */
    public function resourceAssets()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/assets/css' => resource_path('assets/css'),
            ADMINLTETEMPLATE_PATH.'/resources/assets/less' => resource_path('assets/less'),
            ADMINLTETEMPLATE_PATH.'/resources/assets/sass' => resource_path('assets/sass'),
            ADMINLTETEMPLATE_PATH.'/resources/assets/js'   => resource_path('assets/js'),
            ADMINLTETEMPLATE_PATH.'/gulpfile.js'           => base_path('gulpfile.js'),
            ADMINLTETEMPLATE_PATH.'/package.json'          => base_path('package.json'),
        ];
    }

    /**
     * Languages assets copy path.
     *
     * @return array
     */
    public function languages()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/lang' => resource_path('lang/vendor/adminlte_lang'),
        ];
    }

    /**
     * Gravatar path.
     *
     * @return array
     */
    public function gravatar()
    {
        return [
            base_path().'/vendor/creativeorange/gravatar/config/gravatar.php' => config_path('gravatar.php'),
        ];
    }

    /**
     * Config path.
     *
     * @return array
     */
    public function config()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/config/adminlte.php' => config_path('adminlte.php'),
        ];
    }

    /**
     * Spatie menu path.
     *
     * @return array
     */
    public function spatieMenu()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/views/layouts/partials/sidebar_with_spatie_menu.blade.php' =>
                resource_path('views/vendor/adminlte/layouts/partials/sidebar.blade.php')
        ];
    }

    /**
     * Menu path.
     *
     * @return array
     */
    public function menu()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/config/menu.php' =>
                config_path('menu.php')
        ];
    }

    /**
     * Web routes path.
     *
     * @return array
     */
    public function webroutes()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/routes/web.php' =>
                base_path('routes/web.php')
        ];
    }

    /**
     * Api routes path.
     *
     * @return array
     */
    public function apiroutes()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/routes/api.php' =>
                base_path('routes/api.php')
        ];
    }
}
