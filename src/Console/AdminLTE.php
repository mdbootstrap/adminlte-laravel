<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

class AdminLTE extends Command
{
    /**
     * The name and signature of the console command.
     *
    @var string
     */
    protected $signature = 'adminlte-laravel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the AdminLTETemplateServiceProvider provider into config/app.php';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->installAdminLTETemplateServiceProvider();
    }

    /**
     * Install the AdminLTETemplateServiceProvider provider into config/app.php.
     */
    protected function installAdminLTETemplateServiceProvider()
    {
        copy(
            ADMINLTETEMPLATE_PATH.'/src/stubs/app.php.stub',
            config_path('app.php')
        );

        $this->comment('AdminLTETemplateServiceProvider provider installed into config/app.php');
    }
}
