<?php

namespace Acacha\AdminLTETemplateLaravel\Exceptions;

/**
 * Class RouteTypeNotValid.
 *
 * @package Acacha\AdminLTETemplateLaravel\Exceptions
 */
class RouteTypeNotValid extends \Exception
{
    /**
     * SpatieMenuAlreadyExists constructor.
     */
    public function __construct()
    {
        parent::__construct('Route type not valid!');
    }
}
