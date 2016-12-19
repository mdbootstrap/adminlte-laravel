<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class MakeMVC.
 */
class MakeMVC extends MakeVC
{
    use CreatesModels;

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:mvc {link : The route link} {action? : View or controller to create} 
    {--t|type=controller : Type of route to create (regular,controller,resource)} {--m|method=get : HTTP method} 
    {--api : Route is an api route}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a full MVC(Model View Controller) and his corresponding route and menu entry';

    /**
     * MakeMVC constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->createModel($this->argument('link'));
        parent::handle();
    }
}
