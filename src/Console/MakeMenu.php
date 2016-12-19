<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\AdminLTETemplateLaravel\Compiler\StubFileCompiler;
use Acacha\AdminLTETemplateLaravel\Console\Menus\RegularMenu;
use Acacha\AdminLTETemplateLaravel\Console\Routes\GeneratesCode;
use Acacha\AdminLTETemplateLaravel\Filesystem\Filesystem;
use Illuminate\Console\Command;

/**
 * Class MakeMenu.
 */
class MakeMenu extends Command
{

    /**
     * Path to menu file.
     *
     * @var string
     */
    protected $menu_path = 'config/menu.php';

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
        'regular' => RegularMenu::class,
//        'another' => AnotherMenu::class,
    ];

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:menu {link : The menu link} {name? : The menu name} 
        {--t|type=regular : Type of menu to create (regular,todo)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Insert a menu to config/menu file';

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
        $tmpfile = $this->createTmpFileWithMenu();
        $path = $this->getPath($tmpfile);
        add_file_into_file($this->mountpoint(), $path, $dstFile = $this->destinationFile());
        $this->info('Menu ' . $this->name() . ' added to ' .  $dstFile . '.');
        $this->postActions();
    }

    /**
     * Get mountpoint.
     *
     * @return string
     */
    protected function mountpoint()
    {
        return '#adminlte_menu';
    }

    /**
     * Destination route file.
     *
     * @return string
     */
    protected function destinationFile()
    {
        return base_path($this->menu_path);
    }

    /**
     * Crete tmp file with route to add.
     *
     * @return mixed
     */
    protected function createTmpFileWithMenu()
    {
        $temp = tmpfile();
        fwrite($temp, $this->getMenuCode());
        return $temp;
    }

    /**
     * Get route code to insert depending on type.
     *
     * @return mixed
     */
    protected function getMenuCode()
    {
        $type = $this->option('type');
        $class = isset(static::$lookup[$type])
            ? static::$lookup[$type]
            : RegularMenu::class;
        /** @var GeneratesCode $route */
        $route = new $class($this->compiler, $this->filesystem);
        $route->setReplacements([
            $this->argument('link'),
            $this->name()
        ]);
        return $route->code();
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
     * Get the link name.
     *
     * @return array|string
     */
    protected function name()
    {
        if ($this->argument('name') != null) {
            return $this->argument('name');
        }
        return ucfirst($this->argument('link'));
    }

    /**
     * Process input.
     */
    protected function processInput()
    {
        //        $this->validateMethod();
    }

    /**
     * Execute post actions (if exists)
     */
    protected function postActions()
    {
        //
    }
}
