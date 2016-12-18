<?php

namespace Acacha\AdminLTETemplateLaravel\Exceptions;

/**
 * Class SpatieMenuDoesNotExists.
 *
 * @package Acacha\AdminLTETemplateLaravel\Exceptions
 */
class SpatieMenuDoesNotExists extends \Exception
{
    /**
     * SpatieMenuDoesNotExists constructor.
     */
    public function __construct()
    {
        parent::__construct('Spatie menu is not installed. Use command php artisan adminlte:menu to install.');
    }
}
