<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\AdminLTETemplateLaravel\Compiler\StubFileCompiler;
use Acacha\AdminLTETemplateLaravel\Console\Routes\Controller;
use Acacha\AdminLTETemplateLaravel\Console\Routes\ControllerResourceRoute;
use Acacha\AdminLTETemplateLaravel\Console\Routes\ControllerRoute;
use Acacha\AdminLTETemplateLaravel\Console\Routes\GeneratesCode;
use Acacha\AdminLTETemplateLaravel\Console\Routes\RegularRoute;
use Acacha\AdminLTETemplateLaravel\Exceptions\RouteTypeNotValid;
use Acacha\AdminLTETemplateLaravel\Exceptions\SpatieMenuDoesNotExists;
use Acacha\AdminLTETemplateLaravel\Filesystem\Filesystem;
use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Artisan;
use Route;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

/**
 * Class MakeRoute.
 */
class MakeRoute extends Command
{
    use Controller, CreatesModels;

    /**
     * Path to web routes file.
     *
     * @var string
     */
    protected $web_routes_path = 'routes/web.php';

    /**
     * Path to api routes file.
     *
     * @var string
     */
    protected $api_routes_path = 'routes/api.php';

    /**
     * Compiler for stub file.
     *
     * @var StubFileCompiler
     */
    protected $compiler;

    /**
     * Compiler for stub file.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var array
     */
    protected static $lookup = [
        'regular' => RegularRoute::class,
        'controller' => ControllerRoute::class,
        'resource' => ControllerResourceRoute::class,
    ];

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:route {link : The route link} {action? : View or controller to create} 
    {--t|type=regular : Type of route to create (regular,controller,resource)} {--m|method=get : HTTP method} 
    {--api : Route is an api route} {--a|createaction : Create view or controller after route}
    {--menu : Create also menu entry using make:menu command} {--model : Create also a model using command make:model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a route to routes/web.php file';

    /**
     * AdminLTERoute constructor.
     *
     * @param StubFileCompiler $compiler
     * @param Filesystem $filesystem
     */
    public function __construct(StubFileCompiler $compiler, Filesystem $filesystem)
    {
        parent::__construct();
        $this->compiler = $compiler;
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->processInput();
        $this->warnIfRouteAlreadyExists($link = $this->argument('link'));
        $tmpfile = $this->createTmpFileWithRoute();
        $path = $this->getPath($tmpfile);
        add_file_into_file($this->mountpoint(), $path, $dstFile = $this->destinationFile());
        $this->info('Route ' . undot_path($link) . ' added to ' .  $dstFile . '.');
        $this->postActions();
    }

    /**
     * Get mountpoint.
     *
     * @return string
     */
    protected function mountpoint()
    {
        if ($this->option('api')) {
            return '#adminlte_api_routes';
        }
        return '#adminlte_routes';
    }

    /**
     * Destination route file.
     *
     * @return string
     */
    protected function destinationFile()
    {
        if ($this->option('api')) {
            return base_path($this->api_routes_path);
        }
        return base_path($this->web_routes_path);
    }

    /**
     * Warn if route already exists.
     *
     * @param $link
     */
    protected function warnIfRouteAlreadyExists($link)
    {
        if ($this->routeExists($link)) {
            if ($this->confirm('Route already exists. Do you wish to continue?')) {
                return;
            }
            die();
        }
    }

    /**
     * Check if route exists.
     *
     * @param $link
     * @return mixed
     */
    protected function routeExists($link)
    {
        if ($this->option('api')) {
            return $this->apiRouteExists($link);
        }
        return $this->webRouteExists($link);
    }

    /**
     * Check if web route exists.
     *
     * @param $link
     * @return mixed
     */
    protected function webRouteExists($link)
    {
        $link = $this->removeTrailingSlashIfExists($link);
        $link = $this->removeDuplicatedTrailingSlashes($link);
        foreach (Route::getRoutes() as $value) {
            if (in_array(strtoupper($this->option('method')), array_merge($value->methods(), ['ANY'])) &&
                $value->uri() === $link) {
                return true;
            }
        }
        return false;
    }

    /**
     * Remove (if exists) trailing slash from link.
     *
     * @param $link
     * @return string
     */
    protected function removeTrailingSlashIfExists($link)
    {
        if (starts_with($link, '/')) {
            return substr($link, 1);
        }
        return $link;
    }

    /**
     * Remove duplicated trailing slashes.
     *
     * @param $link
     * @return mixed
     */
    protected function removeDuplicatedTrailingSlashes($link)
    {
        return preg_replace('/(\/+)/', '/', $link);
    }

    /**
     * Check if api route exists.
     *
     * @param $link
     * @return mixed
     */
    protected function apiRouteExists($link)
    {
        return $this->webRouteExists('api/v1/' . $link);
    }

    /**
     * Crete tmp file with route to add.
     *
     * @return mixed
     */
    protected function createTmpFileWithRoute()
    {
        $temp = tmpfile();
        fwrite($temp, $this->getRouteCode());
        return $temp;
    }

    /**
     * Get path from file resource.
     *
     * @param $tmpfile
     * @return mixed
     */
    protected function getPath($tmpfile)
    {
        return stream_get_meta_data($tmpfile)['uri'];
    }

    /**
     * Get route code to insert depending on type.
     *
     * @return mixed
     */
    protected function getRouteCode()
    {
        $type = $this->option('type');
        $class = isset(static::$lookup[$type])
            ? static::$lookup[$type]
            : RegularRoute::class;
        /** @var GeneratesCode $route */
        $route = new $class($this->compiler, $this->filesystem);
        $route->setReplacements([
            undot_path($this->argument('link')),
            $this->action(),
            $this->method()
        ]);
        return $route->code();
    }

    /**
     * Get method.
     *
     * @return string
     */
    protected function method()
    {
        if (strtolower($this->option('method')) == 'head') {
            return 'get';
        }
        return strtolower($this->option('method'));
    }

    /**
     * Get the action replacement.
     *
     * @return array|string
     */
    protected function action()
    {
        if ($this->argument('action') != null) {
            return $this->argument('action');
        }
        if (strtolower($this->option('type')) != 'regular') {
            return $this->argument('link') . 'Controller';
        }
        return $this->argument('link');
    }

    /**
     * Process input.
     */
    protected function processInput()
    {
        $this->validateMethod();
        $this->validateType();
    }

    /**
     * Validate option method.
     */
    protected function validateMethod()
    {
        if (! in_array(strtoupper($this->option('method')), $methods = array_merge(Router::$verbs, ['ANY']))) {
            throw new MethodNotAllowedException($methods);
        }
    }

    /**
     * Validate option type.
     */
    protected function validateType()
    {
        if (! in_array(strtolower($this->option('type')), ['regular','controller','resource'])) {
            throw new RouteTypeNotValid();
        }
    }

    /**
     * Execute post actions (if exists)
     */
    protected function postActions()
    {
        if ($this->option('createaction') != null) {
            $this->createAction();
        }
        if ($this->option('menu') != null) {
            $this->createMenu();
        }
        if ($this->option('model') != null) {
            $this->createModel($this->argument('link'));
        }
    }

    /**
     * Create menu.
     */
    protected function createMenu()
    {
        try {
            $this->warnIfSpatieMenuIsNotInstalled();
        } catch (\Exception $e) {
            //Skip installation of menu
            $this->error($e->getMessage());
            return;
        }
        Artisan::call('make:menu', [
            'link' => $link = undot_path($this->argument('link')),
            'name' => ucfirst($link),
        ]);
        $this->info('Menu entry ' . $link .' added to config/menu.php file.');
    }

    /**
     * Warn if spatie menu ins not installed.
     *
     * @throws SpatieMenuDoesNotExists
     */
    protected function warnIfSpatieMenuIsNotInstalled()
    {
        if (!(app()->getProvider('Spatie\Menu\Laravel\MenuServiceProvider'))) {
            throw new SpatieMenuDoesNotExists();
        }
    }

    /**
     * Create action (view|controller).
     */
    protected function createAction()
    {
        if (strtolower($this->option('type')) == 'regular' || $this->option('type') == null) {
            return $this->createView();
        }
        if (strtolower($this->option('type')) == 'controller') {
            return $this->createController();
        }
        return $this->createResourceController();
    }

    /**
     * Create View.
     *
     * @param null $name
     */
    protected function createView($name = null)
    {
        if ($name == null) {
            $name = $this->action();
        }
        Artisan::call('make:view', [
            'name' => $name
        ]);
        $this->info('View ' . undot_path($name) .'.blade.php created.');
    }

    /**
     * Create regular controller.
     */
    protected function createController()
    {
        Artisan::call('make:controller', [
            'name' => $controller = $this->controllerWithoutMethod($this->action())
        ]);
        $this->addMethodToController($controller, $this->controllerMethod($this->action()));
        $this->info('Controller ' . $controller .' created.');
        $this->createView($this->argument('link'));
    }

    /**
     * Create resource controller.
     */
    protected function createResourceController()
    {
        Artisan::call('make:controller', [
            'name' => $controller = $this->controllerWithoutMethod($this->action()),
            '--resource' => true
        ]);
        $this->info('Resource Controller ' . $controller .' created.');
        $this->createView($this->argument('link'));
    }

    /**
     * Add method to controller.
     *
     * @param $controller
     * @param $controllerMethod     *
     */
    protected function addMethodToController($controller, $controllerMethod)
    {
        $tmpfile = $this->createTmpFileWithMethod($controllerMethod);
        $path = $this->getPath($tmpfile);
        add_file_into_file('\/\/', $path, app_path('Http/Controllers/' . $controller . '.php'));
    }

    /**
     * Crete tmp file with route to add.
     *
     * @param $controllerMethod
     * @return mixed
     */
    protected function createTmpFileWithMethod($controllerMethod)
    {
        $temp = tmpfile();
        fwrite($temp, $this->getMethodCode($controllerMethod));
        return $temp;
    }

    /**
     * Get method code.
     *
     * @param $controllerMethod
     * @return mixed
     */
    protected function getMethodCode($controllerMethod)
    {
        return $this->compiler->compile(
            $this->filesystem->get($this->getMethodStubPath()),
            [
                'METHOD' => $controllerMethod,
                'VIEW' => $this->argument('link')
            ]
        );
    }

    /**
     * Get method stub path.
     *
     * @return string
     */
    protected function getMethodStubPath()
    {
        return __DIR__ . '/stubs/method.stub';
    }
}
