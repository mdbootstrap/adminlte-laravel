<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 * Class Username.
 */
class Username extends Command
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
    protected $signature = 'adminlte:username {--f|force : Force overwrite of files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Changes to login and register with username';

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
        $this->publishAuthConfigFile();
        $this->publishUserClass();
        $this->runMigration();
    }

    /**
     * Install auth config file.
     */
    private function publishAuthConfigFile()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::authConfig());
    }

    /**
     * Publish User class.
     */
    private function publishUserClass()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::userClass());
    }

    /**
     * Run migration.
     */
    private function runMigration()
    {
        $this->info('Installing doctrine/dbal');
        passthru('composer require doctrine/dbal');
        $this->info('Running php artisan migrate');
        passthru('php artisan migrate');
    }

    /**
     * Process options before running command.
     */
    private function processOptions()
    {
        $this->force = $this->option('force');
    }
}
