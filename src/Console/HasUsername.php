<?php


namespace Acacha\AdminLTETemplateLaravel\Console;

/**
 * Class HasUsername.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
trait HasUsername
{
    /**
     * Obtains username.
     *
     * @return mixed|null|string
     */
    public function username()
    {
        if (($username = env('ADMIN_USERNAME', null)) != null) {
            return $username;
        }

        if (($username = git_user_name()) != null) {
            return $username;
        }

        return "Admin";
    }
}
