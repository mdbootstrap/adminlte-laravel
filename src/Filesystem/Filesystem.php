<?php

namespace Acacha\AdminLTETemplateLaravel\Filesystem;

/**
 * Class Filesystem.
 *
 * @package Acacha\Llum\Filesystem
 */
class Filesystem
{

    /**
     * Root directory
     *
     * @var string
     */
    protected $root;

    /**
     * @param null|string $root
     */
    public function __construct($root = '/')
    {
        $this->root = $root;
    }

    /**
     *
     * Overwrite file with provided content.
     *
     * @param $file
     * @param $content
     */
    public function overwrite($file, $content)
    {
        $this->put($this->getPath($file), $content);
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
        if ($this->exists($this->getPath($file))) {
            throw new FileAlreadyExists;
        }
        $this->put($file, $content);
    }

    /**
     * Get file contents.
     * @param $file
     * @return string
     * @throws FileDoesNotExists
     */
    public function get($file)
    {
        $path = $this->getPath($file);

        if (! file_exists($path)) {
            throw new FileDoesNotExists;
        }

        return file_get_contents($path);
    }

    /**
     * Put content in file.
     *
     * @param $file
     * @param $content
     * @param $flag
     * @return int
     */
    protected function put($file, $content, $flag = null)
    {
        return file_put_contents($this->getPath($file), $content, $flag);
    }

    /**
     * Does the given file exist?
     *
     * @param $file
     * @return bool
     */
    public function exists($file)
    {
        return file_exists($this->getPath($file));
    }

    /**
     * Build the path to the file.
     *
     * @param $file
     * @return string
     */
    protected function getPath($file)
    {
        return $this->root . '/' . $file;
    }

    /**
     * Append to a file
     *
     * @param $file
     * @param $body
     * @return int
     */
    public function append($file, $body)
    {
        return $this->put($file, $body, FILE_APPEND);
    }
    /**
     * Delete a file
     *
     * @param $file
     */
    public function delete($file)
    {
        unlink($this->getPath($file));
    }
}
