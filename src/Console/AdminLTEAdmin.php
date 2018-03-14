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
        $this->createAdminUser();
        $this->info('User ' . $this->username() . '(' . $this->email() . ') ' .
            $this->passwordInfo() . ' created succesfully!');
        $this->call('make:adminUserSeeder');
        $this->info('A database seed has been created to permanently add admin user to database.');
    }

    /**
     * Create admin user.
     */
    protected function createAdminUser()
    {
        try {
            factory(get_class(app('App\User')))->create([
                    "name" => env('ADMIN_USER', $this->username()),
                    "email" => env('ADMIN_EMAIL', $this->email()),
                    "password" => bcrypt(env('ADMIN_PWD', '123456'))]);
        } catch (\Illuminate\Database\QueryException $exception) {
        }
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
