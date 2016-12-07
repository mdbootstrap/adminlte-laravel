<?php

namespace Acacha\AdminLTETemplateLaravel\Console;

use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Filesystem as Flysystem;
use League\Flysystem\MountManager;

/**
 * Class Installable.
 */
trait Installable
{
    /**
     * Install files from array.
     *
     * @param $files
     */
    private function install($files)
    {
        foreach ($files as $fileSrc => $fileDst) {
            if (file_exists($fileDst) && !$this->force && !$this->confirmOverwrite(basename($fileDst))) {
                return;
            }
            if ($this->files->isFile($fileSrc)) {
                $this->publishFile($fileSrc, $fileDst);
            } elseif ($this->files->isDirectory($fileSrc)) {
                $this->publishDirectory($fileSrc, $fileDst);
            } else {
                $this->error("Can't locate path: <{$fileSrc}>");
            }
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

    /**
     * Create the directory to house the published files if needed.
     *
     * @param string $directory
     *
     * @return void
     */
    protected function createParentDirectory($directory)
    {
        if (!$this->files->isDirectory($directory)) {
            $this->files->makeDirectory($directory, 0755, true);
        }
    }

    /**
     * Publish the file to the given path.
     *
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    protected function publishFile($from, $to)
    {
        $this->createParentDirectory(dirname($to));
        $this->files->copy($from, $to);
        $this->status($from, $to, 'File');
    }

    /**
     * Publish the directory to the given directory.
     *
     * @param string $from
     * @param string $to
     *
     * @return void
     */
    protected function publishDirectory($from, $to)
    {
        $manager = new MountManager([
            'from' => new Flysystem(new LocalAdapter($from)),
            'to'   => new Flysystem(new LocalAdapter($to)),
        ]);
        foreach ($manager->listContents('from://', true) as $file) {
            if ($file['type'] === 'file' && (!$manager->has('to://'.$file['path']) || $this->force)) {
                $manager->put('to://'.$file['path'], $manager->read('from://'.$file['path']));
            }
        }
        $this->status($from, $to, 'Directory');
    }

    /**
     * Write a status message to the console.
     *
     * @param string $from
     * @param string $to
     * @param string $type
     *
     * @return void
     */
    protected function status($from, $to, $type)
    {
        $from = str_replace(base_path(), '', realpath($from));
        $to = str_replace(base_path(), '', realpath($to));
        $this->line('<info>Copied '. $type. '</info> <comment>['. $from.
            ']</comment> <info>To</info> <comment>['.$to.']</comment>');
    }
}
