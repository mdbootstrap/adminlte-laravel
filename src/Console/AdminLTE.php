<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class AdminLTE.
 */
class AdminLTE extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte-laravel:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Acacha AdminLTE Template into fresh laravel project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->installHomeController();
        $this->installAuthController();
        $this->installPublicAssets();
        $this->installViews();
        $this->installResourceAssets();
    }

    /**
     * Install Home Controller.
     */
    private function installHomeController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::homeController());
    }

    /**
     * Install Auth controller.
     */
    private function installAuthController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::authController());
    }

    /**
     * Install public assets.
     */
    private function installPublicAssets()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::publicAssets());
    }

    /**
     * Install views.
     */
    private function installViews()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::views());
    }

    /**
     * Install resource assets.
     */
    private function installResourceAssets()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::resourceAssets());
    }

    /**
     * Install files from array.
     *
     * @param $files
     */
    private function install($files)
    {
        foreach ($files as $fileSrc => $fileDst) {
            copy($fileSrc, $fileDst);
        }
    }
}
