<?php


namespace Piscibus\Notifly\Commands;

use Illuminate\Console\GeneratorCommand;

/**
 * Class IconMakeCommand
 * @package Piscibus\Notifly\Commands
 */
class IconMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'notifly:make:icon';

    /**
     * @var string
     */
    protected $description = 'Create a new notification icon class';

    /**
     * @var string
     */
    protected $type = 'Icon';

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/icon.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Notifications\Icons';
    }
}
