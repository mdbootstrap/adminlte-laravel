<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

/**
 * Class HasEmail.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
trait HasEmail
{
    /**
     * Obtain admin email.
     *
     * @return bool|string
     */
    protected function email()
    {
        if (($email = env('ADMIN_EMAIL', null)) != null) {
            return $email;
        }

        if (($email = git_user_email()) != null) {
            return $email;
        }

        return "admin@example.com";
    }
}
