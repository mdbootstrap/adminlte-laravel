<?php

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->in('src');

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::SYMFONY_LEVEL)
    ->fixers(['-yoda_conditions', 'short_array_syntax', '-phpdoc_align'])
    ->finder($finder);