<?php

use Illuminate\Database\Seeder;

/**
 * Class AdminUserSeeder
 */
class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            factory(App\User::class)->create([
                    "name" => env('ADMIN_USER', "$USER_NAME$"),
                    "email" => env('ADMIN_EMAIL', "$USER_EMAIL"),
                    "password" => bcrypt(env('ADMIN_PWD', '123456'))]);
        } catch (\Illuminate\Database\QueryException $exception) {
        }
    }
}
