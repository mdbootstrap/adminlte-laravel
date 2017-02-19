<?php

namespace Acacha\AdminLTETemplateLaravel\Console\Routes;

use Acacha\Filesystem\Compiler\StubFileCompiler;
use Acacha\Filesystem\Filesystem;

/**
 * Class ControllerRoute.
 *
 * @package Acacha\AdminLTETemplateLaravel\Console\Routes
 */
class ControllerRoute extends Route
{
    use Controller;

    /**
     * Route constructor.
     *
     * @param StubFileCompiler $compiler
     * @param Filesystem $filesystem
     */
    public function __construct(StubFileCompiler $compiler, Filesystem $filesystem)
    {
        parent::__construct($compiler, $filesystem);
    }

    /**
     * Get stub path.
     *
     * @return mixed
     */
    protected function getStubPath()
    {
        return __DIR__ . '/../stubs/route_with_controller.stub';
    }

    /**
     * Obtain replacements.
     *
     * @return array
     */
    protected function obtainReplacements()
    {
        return [
            'ROUTE_LINK' => $link = $this->getReplacements()[0],
            'ROUTE_CONTROLLER' => $this->controller($this->getReplacements()[1]),
            'ROUTE_METHOD' => $this->getReplacements()[2],
            'ROUTE_NAME' => dot_path($link),
        ];
    }
}
