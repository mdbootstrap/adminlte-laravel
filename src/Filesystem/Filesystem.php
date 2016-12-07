<?php

namespace Acacha\AdminLTETemplateLaravel\Filesystem;

/**
 * Class Filesystem
 */
/**
 * Class Filesystem
 * @package Acacha\Llum\Filesystem
 */
class Filesystem
{

    /**
     *
     * Overwrite file with provided content.
     *
     * @param $file
     * @param $content
     */
    public function overwrite($file, $content)
    {
        $this->put($file, $content);
    }

    /**
     * Create file with provided content if not exists.
     *
     * @param $file
     * @param $content
     * @throws FileAlreadyExists
     */
    public function make($file, $content)
    {
        if ( $this->exists($file))
        {
            throw new FileAlreadyExists;
        }
        $this->put($file, $content);
    }

    /**
     * Get file contents
     */
    public function get($file) {
        return file_get_contents($file);
    }

    /**
     * Put content in file.
     *
     * @param $file
     * @param $content
     * @return int
     */
    protected function put($file, $content) {
        return file_put_contents($file, $content);
    }
}