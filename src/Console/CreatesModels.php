<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

/**
 * Class CreatesModels.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console
 */
trait CreatesModels
{
    /**
     * Create a model and migration using make:model command
     */
    public function createModel($name)
    {
        passthru('php artisan make:model -m ' . snake_case($name));
    }
}
