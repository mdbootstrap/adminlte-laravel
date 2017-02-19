<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\Filesystem\Compiler\StubFileCompiler;
use Acacha\Filesystem\Filesystem;
use Illuminate\Console\Command;

/**
 * Class MakeAdminUserSeeder.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
class MakeAdminUserSeeder extends Command
{
    use HasUsername, HasEmail;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:adminUserSeeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new seed to add admin user to database';

    /**
     * Filesystem.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Compiler for stub file.
     *
     * @var StubFileCompiler
     */
    protected $compiler;

    /**
     * Create a new command instance.
     *
     * @param Filesystem $filesystem
     * @param StubFileCompiler $compiler
     */
    public function __construct(Filesystem $filesystem, StubFileCompiler $compiler)
    {
        parent::__construct();
        $this->filesystem = $filesystem;
        $this->compiler = $compiler;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        try {
            $this->filesystem->overwrite(
                $path = database_path('seeds/' . config('AdminUserSeeder', 'AdminUserSeeder.php')),
                $this->compiler->compile(
                    $this->filesystem->get($this->getStubPath()),
                    [
                        "USER_NAME" => $this->username(),
                        "USER_EMAIL" => $this->email(),
                    ]
                )
            );
            $this->info('File ' . $path . ' created');
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * Get path to stub.
     *
     * @return string
     */
    protected function getStubPath()
    {
        return __DIR__ . '/stubs/AdminUserSeeder.php.stub';
    }
}
