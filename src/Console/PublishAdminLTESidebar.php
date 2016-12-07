<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class PublishAdminLTESidebar.
 */
class PublishAdminLTESidebar extends Command
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
    protected $signature = 'adminlte-laravel:sidebar {--f|force : Force overwrite of files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description =
        'Publish Acacha adminlte sidebar view in your project allowing you to customize your project sidebar';

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
     * @return void
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
        $this->publishSidebarView();
    }

    /**
     * Install views.
     */
    private function publishSidebarView()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::sidebarView());
    }

    /**
     * Process options before running command.
     */
    private function processOptions()
    {
        $this->force = $this->option('force');
    }
}
