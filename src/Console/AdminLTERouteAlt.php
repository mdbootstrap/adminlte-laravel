<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class AdminLTERouteAlt.
 */
class AdminLTERouteAlt extends AdminLTERoute
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte:route {link : The route link} {action? : View or controller to create} 
    {--t|type=regular : Type of route to create (regular,controller,resource)} {--m|method=get : HTTP method} 
    {--api : Route is an api route} {--a|createaction : Create view or controller after route}';
}
