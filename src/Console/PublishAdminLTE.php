<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use Illuminate\Console\Command;

/**
 * Class PublishAdminLTE.
 */
class PublishAdminLTE extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'adminlte-laravel:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish Acacha AdminLTE Template files into laravel project';

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->publishHomeController();
        $this->changeRegisterController();
        $this->publishPublicAssets();
        $this->publishViews();
        $this->publishResourceAssets();
        $this->publishTests();
        $this->publishLanguages();
        $this->publishGravatar();
    }

    /**
     * Install Home Controller.
     */
    private function publishHomeController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::homeController());
    }

    /**
     * Install Auth controller.
     */
    private function changeRegisterController()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::registerController());
    }

    /**
     * Install public assets.
     */
    private function publishPublicAssets()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::publicAssets());
    }

    /**
     * Install views.
     */
    private function publishViews()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::views());
    }

    /**
     * Install resource assets.
     */
    private function publishResourceAssets()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::resourceAssets());
    }

    /**
     * Install resource assets.
     */
    private function publishTests()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::tests());
    }

    /**
     * Install language assets.
     */
    private function publishLanguages()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::languages());
    }

    /**
     * Install gravatar config file.
     */
    private function publishGravatar()
    {
        $this->install(\Acacha\AdminLTETemplateLaravel\Facades\AdminLTE::gravatar());
    }

    /**
     * Install files from array.
     *
     * @param $files
     */
    private function install($files)
    {
        foreach ($files as $fileSrc => $fileDst) {
            if (file_exists($fileDst) && !$this->confirmOverwrite(basename($fileDst))) {
                return;
            }
            copy($fileSrc, $fileDst);
            $this->info('Copied file ' . $fileSrc . ' to ' . $fileDst );
        }
    }

    /**
     * @param $fileName
     * @param string $prompt
     *
     * @return bool
     */
    protected function confirmOverwrite($fileName, $prompt = '')
    {
        $prompt = (empty($prompt))
            ? $fileName.' already exists. Do you want to overwrite it? [y|N]'
            : $prompt;
        return $this->confirm($prompt, false);
    }
}
