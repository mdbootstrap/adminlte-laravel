<?php

use Illuminate\Support\Facades\Facade;

/**
 * Class AdminLTE.
 */
class AdminLTE extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'acacha/AdminLTE';
    }
}
