<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\AdminLTETemplateLaravel\Exceptions\SpatieMenuAlreadyExists;
use Acacha\AdminLTETemplateLaravel\Facades\AdminLTE;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class AdminLTEMenu.
 */
class AdminLTEMenu extends Command
{
    use Installable;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte-laravel:menu {--f|force : Force overwrite of files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces sidebar view with a sidebar using spatie/laravel-menu menu';

    /**
     * Force overwrite of files.
     *
     * @var bool
     */
    protected $force = false;

    /**
     * Create a new command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     *
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->processOptions();
        $this->checkIfSpatieMenuAlreadyInstalled();
        $this->installSpatieMenu();
        $this->publishSpatieMenu();
        $this->publishSpatieMenuConfig();
    }

    /**
     * Check if spatie menu is already installed.
     *
     * @throws SpatieMenuAlreadyExists
     */
    protected function checkIfSpatieMenuAlreadyInstalled()
    {
        if ((app()->getProvider('Spatie\Menu\Laravel\MenuServiceProvider')) && ! $this->force) {
            throw new SpatieMenuAlreadyExists();
        }
        return;
    }

    /**
     * Install spatie/laravel-menu.
     */
    protected function installSpatieMenu()
    {
        passthru('llum package laravel-menu');
    }

    /**
     * Process options before running command.
     */
    protected function processOptions()
    {
        $this->force = $this->option('force');
    }

    /**
     * Publish sidebar with spatie menu
     */
    protected function publishSpatieMenu()
    {
        $this->install(AdminLTE::spatieMenu());
    }

    /**
     * Publish spatie menu config
     */
    protected function publishSpatieMenuConfig()
    {
        $this->install(AdminLTE::menu());
    }
}
