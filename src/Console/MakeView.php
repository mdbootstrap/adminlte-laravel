<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class MakeView.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
class MakeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {name : the name of the view}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new view using adminlte default layout';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     *
     */
    public function handle()
    {
        try {
            $this->filesystem->overwrite(
                $path = resource_path('views/' . $this->viewPath()),
                $this->filesystem->get($this->getStubPath())
            );
            $this->info('File ' . $path . ' created');
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * Get stub path
     */
    protected function getStubPath()
    {
        return __DIR__ . '/stubs/view.stub';
    }

    /**
     * The view destination path.
     *
     * @return string
     */
    protected function viewPath()
    {
        return $this->constructViewBaldeName($this->argument('name'));
    }

    /**
     * Create full relative path to blade template from view name.
     * @param $name
     * @return string
     */
    protected function constructViewBaldeName($name)
    {
        return $this->dottedPathToSlahesPath($name) . '.blade.php';
    }

    /**
     * Converts dotted notation to path slashes.
     * @param $name
     * @return mixed
     */
    protected function dottedPathToSlahesPath($name)
    {
        return str_replace(".", "/", $name);
    }
}
