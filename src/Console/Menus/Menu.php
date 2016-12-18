<?php

namespace Acacha\AdminLTETemplateLaravel\Console\Menus;

use Acacha\AdminLTETemplateLaravel\Compiler\StubFileCompiler;
use Acacha\AdminLTETemplateLaravel\Console\Routes\GeneratesCode;
use Acacha\AdminLTETemplateLaravel\Filesystem\Filesystem;

/**
 * Class Menu.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console\Menus
 */
abstract class Menu implements GeneratesCode
{

    /**
     * Compiler for stub file.
     *
     * @var StubFileCompiler
     */
    protected $compiler;

    /**
     * Compiler for stub file.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * Replacements.
     *
     * @var array
     */
    protected $replacements;

    /**
     * Route constructor.
     *
     * @param StubFileCompiler $compiler
     * @param Filesystem $filesystem
     */
    public function __construct(StubFileCompiler $compiler, Filesystem $filesystem)
    {
        $this->compiler = $compiler;
        $this->filesystem = $filesystem;
    }

    /**
     * @return array
     */
    public function getReplacements()
    {
        return $this->replacements;
    }

    /**
     * @param array $replacements
     */
    public function setReplacements($replacements)
    {
        $this->replacements = $replacements;
    }

    /**
     * Generate route code.
     */
    public function code()
    {
        return $this->compiler->compile(
            $this->filesystem->get($this->getStubPath()),
            $this->obtainReplacements()
        );
    }

    /**
     * Get stub path.
     *
     * @return mixed
     */
    abstract protected function getStubPath();

    /**
     * Obtain replacements for stub.
     *
     * @return mixed
     */
    abstract protected function obtainReplacements();
}
