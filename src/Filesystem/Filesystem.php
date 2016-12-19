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
     * @param bool $recursive
     * @throws FileAlreadyExists
     */
    public function make($file, $content, $recursive = false)
    {
        if ($this->exists($this->getPath($file))) {
            throw new FileAlreadyExists;
        }
        $this->put($file, $content, 0, $recursive);
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
     * @param bool $recursive
     * @return int
     */
    public function put($file, $content, $flag = null, $recursive = false)
    {
        if ($recursive) {
            $this->createParentFolder($file);
        }
        return file_put_contents($this->getPath($file), $content, $flag);
    }

    /**
     * Create parent folder recursively (if not exists).
     *
     * @param $file
     * @return bool
     */
    public function createParentFolder($file)
    {
        if (! file_exists($folder = dirname($file))) {
            return mkdir(dirname($file), 0775, true);
        }
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
