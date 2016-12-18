<?php

namespace Acacha\AdminLTETemplateLaravel\Console\Routes;

/**
 * Class Controller.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console\Routes
 */
trait Controller
{
    /**
     * Obtain controller.
     *
     * @param $controllername
     * @return string
     */
    protected function controller($controllername)
    {
        if (str_contains($controllername, '/')) {
            $controllername = str_replace('/', '\\', $controllername);
        }

        if (str_contains($controllername, '@')) {
            return ucfirst($controllername);
        }
        return ucfirst($controllername . '@index');
    }

    /**
     * Obtain controller.
     *
     * @param $controllername
     * @return string
     */
    protected function controllerWithoutMethod($controllername)
    {
        if (str_contains($controller = $controllername, '@')) {
            return ucfirst(substr($controllername, 0, strpos($controllername, '@')));
        }
        return ucfirst($controllername);
    }

    /**
     * Get method from controller name.
     *
     * @param $controllername
     * @return string
     */
    protected function controllerMethod($controllername)
    {
        if (str_contains($controller = $controllername, '@')) {
            return substr($controllername, strpos($controllername, '@')+1, strlen($controllername));
        }
        return 'index';
    }
}
