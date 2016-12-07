<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Acacha\AdminLTETemplateLaravel\Compiler\StubFileCompiler;
use Acacha\AdminLTETemplateLaravel\Filesystem\Filesystem;
use Illuminate\Console\Command;

/**
 * Class MakeAdminUserSeeder.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
class MakeAdminUserSeeder extends Command
{
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
    protected $description = 'Creates a seed to add admin user to database';

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
                database_path('seeds/' . config('AdminUserSeeder','AdminUserSeeder.php')),
                $this->compiler->compile(
                    $this->filesystem->get($this->getStubPath()),
                    [
                        "USER_NAME$" => $this->username(),
                        "USER_EMAIL$" => $this->email(),
                    ]));
        } catch (\Exception $e) {
            print_r($e->getMessage());
        }
    }

    /**
     * Get path to stub.
     *
     * @return string
     */
    protected function getStubPath() {
        return __DIR__ . '/stubs/AdminUserSeeder.php.stub';
    }

    /**
     * Obtain admin username.
     *
     * @return bool|string
     */
    protected function username()
    {
        if ($username = env('ADMIN_USERNAME', null) != null) return $username;

        if ($username = git_user_name() != null) return $username;

        return "Admin";
    }

    /**
     * Obtain admin username.
     *
     * @return bool|string
     */
    protected function email()
    {
        if ($email = env('ADMIN_EMAIL', null) != null) return $email;

        if ($email = git_user_email() != null) return $email;

        return "admin@example.com";
    }
}
