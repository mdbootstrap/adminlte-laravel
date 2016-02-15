<?php
/*
*
* (c) Sergi Tur Badenas <sergiturbadenas@gmail.com>
*
*
* For the full copyright and license information, please view the LICENSE.txt
* file that was distributed with this source code.
* 
*/
namespace Acacha\AdminLTETemplateLaravel\app\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Route;

/**
 * Class AdminLTETemplateServiceProvider
 * @package Acacha\AdminLTETemplateLaravel\Providers
 */
class AdminLTETemplateServiceProvider extends ServiceProvider
{
    use AppNamespaceDetectorTrait;

    private function registerRoutes()
    {

        Route::controller(
            'auth', $this->getAppNamespace() . 'Http\Controllers\Auth\AuthController' ,
            [ 'getLogin' => 'auth.login',
              'getLogout' => 'auth.logout',
              'getRegister' => 'auth.register'
            ]);
        Route::controller(
            'password' , $this->getAppNamespace() . 'Http\Controllers\Auth\PasswordController',
            [ 'getReset' => 'auth.reset',] );

        Route::get('/home', ['as' => 'home','middleware' => 'auth', function () {
            return view('home');
        }]);

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRoutes();
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishPublicAssets();
        $this->publishViews();
        $this->publishResourceAssets();
    }

    /**
     * Publish package views to Laravel project
     *
     * @return void
     */
    private function publishViews()
    {
        $this->loadViewsFrom( dirname(__FILE__) . '/../resources/views/', 'adminltetemplate');

        $this->publishes([
            dirname(__FILE__) . '/../../resources/views/auth' => base_path('resources/views/auth'),
            dirname(__FILE__) . '/../../resources/views/errors' => base_path('resources/views/errors'),
            dirname(__FILE__) . '/../../resources/views/partials' => base_path('resources/views/partials'),
            dirname(__FILE__) . '/../../resources/views/app.blade.php' => base_path('resources/views/app.blade.php'),
            dirname(__FILE__) . '/../../resources/views/home.blade.php' => base_path('resources/views/home.blade.php'),
            dirname(__FILE__) . '/../../resources/views/welcome.blade.php' => base_path('resources/views/welcome.blade.php'),
        ]);
    }

    /**
     * Publish package resource assets to Laravel project
     *
     * @return void
     */
    private function publishResourceAssets()
    {
        $this->publishes([
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/build/bootstrap-less' => base_path('resources/assets/less/bootstrap'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/build/less' => base_path('resources/assets/less/admin-lte'),
            dirname(__FILE__) . '/../../gulpfile.js' => base_path('gulpfile.js'),

        ]);
    }

    /**
     * Publish public resource assets to Laravel project
     *
     * @return void
     */
    private function publishPublicAssets()
    {
        $this->publishes([
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/bootstrap/css' => public_path('css'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/bootstrap/fonts' => public_path('fonts'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/bootstrap/js' => public_path('js'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/dist/css' => public_path('css'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/dist/img' => public_path('img'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/dist/js' => public_path('js'),
            dirname(__FILE__) . '/../../../../../almasaeed2010/adminlte/plugins' => public_path('plugins'),
        ], 'assets');
    }
}
