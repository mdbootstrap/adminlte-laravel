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
     * Auth controller copy path.
     *
     * @return array
     */
    public function authController()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/src/stubs/AuthController.stub' => app_path('Http/Controllers/Auth/AuthController.php'),
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
     * Views copy path.
     *
     * @return array
     */
    public function views()
    {
        return [
            ADMINLTETEMPLATE_PATH.'/resources/views/auth'              => base_path('resources/views/auth'),
            ADMINLTETEMPLATE_PATH.'/resources/views/auth/emails'       => base_path('resources/views/auth/emails'),
            ADMINLTETEMPLATE_PATH.'/resources/views/errors'            => base_path('resources/views/errors'),
            ADMINLTETEMPLATE_PATH.'/resources/views/layouts'           => base_path('resources/views/layouts'),
            ADMINLTETEMPLATE_PATH.'/resources/views/home.blade.php'    => base_path('resources/views/home.blade.php'),
            ADMINLTETEMPLATE_PATH.'/resources/views/welcome.blade.php' => base_path('resources/views/welcome.blade.php'),
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
            ADMINLTETEMPLATE_PATH.'/resources/assets/less' => base_path('resources/assets/less'),
            ADMINLTETEMPLATE_PATH.'/gulpfile.js'           => base_path('gulpfile.js'),
        ];
    }
}
