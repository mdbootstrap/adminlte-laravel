<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class MakeV.
 */
class MakeV extends Command
{

    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:v {link : The route link} {action? : View to create} 
    {--t|type=regular : Type of route to create (regular,controller,resource)} {--m|method=get : HTTP method} 
    {--api : Route is an api route}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a view with his corresponding route and menu entry';

    /**
     * MakeV constructor.
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
        $this->info('Running command ' . $command = $this->command());
        passthru($command);
    }

    /**
     * Obtain command.
     *
     * @return string
     */
    protected function command()
    {
        $api = $this->option('api') ? ' --api '  : '';
        $action = $this->argument('action') ? ' ' . $this->argument('action') . ' ' : '';
        return 'php artisan make:route ' . $this->argument('link') . $action . ' --type=' . $this->option('type') .
            ' --method=' . $this->option('method') .
            $api .
            ' -a --menu';
    }
}
