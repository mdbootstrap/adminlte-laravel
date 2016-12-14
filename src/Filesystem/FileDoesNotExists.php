<?php

namespace Acacha\AdminLTETemplateLaravel\Filesystem;

/**
 * Class FileDoesNotExists.
 *
 * @package Acacha\AdminLTETemplateLaravel\Filesystem
 */
class FileDoesNotExists extends \Exception
{
    /**
     * FileDoesNotExists constructor.
     */
    public function __construct()
    {
        parent::__construct('File does not exists');
    }
}
