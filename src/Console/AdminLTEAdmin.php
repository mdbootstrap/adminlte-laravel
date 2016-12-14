<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class AdminLTEAdmin.
 */
class AdminLTEAdmin extends Command
{
    use HasUsername, HasEmail;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte-laravel:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a seed for admin user and execute seed';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('make:adminUserSeeder');
        exec('composer dumpautoload 2>&1');
        sleep(3);
        $this->call('db:seed', [
            '--class' => basename(config('AdminUserSeeder', 'AdminUserSeeder.php'), ".php")
        ]);
        $this->info('User ' . $this->username() . '(' . $this->email() . ') ' .
            $this->passwordInfo() . ' created succesfully!');
    }

    /**
     * Get password info.
     */
    protected function passwordInfo()
    {
        if (env('ADMIN_PWD', '123456') == '123456') {
            return 'with password 123456';
        }
        return 'with the environemnt password (env var ADMIN_PWD)';
    }
}
