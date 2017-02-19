<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\Filesystem\Filesystem;
use Illuminate\Console\Command;

/**
 * Class MakeView.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
class MakeView extends Command
{

    /**
     * The filesystem instance.
     *
     * @var \Acacha\Filesystem\Filesystem
     */
    protected $filesystem;

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
     * @param Filesystem $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try {
            $this->filesystem->make(
                $path = resource_path('views/' . $this->viewPath()),
                $this->filesystem->get($this->getStubPath()),
                true
            );
            $this->info('File ' . $path . ' created');
        } catch (\Exception $e) {
            $this->error($e->getMessage());
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
        return $this->constructViewBladeName($this->argument('name'));
    }

    /**
     * Create full relative path to blade template from view name.
     *
     * @param $name
     * @return string
     */
    protected function constructViewBladeName($name)
    {
        return $this->dottedPathToSlashesPath($name) . '.blade.php';
    }

    /**
     * Converts dotted notation to path slashes.
     *
     * @param $name
     * @return mixed
     */
    protected function dottedPathToSlashesPath($name)
    {
        return str_replace(".", "/", $name);
    }
}
