<?php


namespace Piscibus\Notifly\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class NotificationMakeCommand
 * @package Piscibus\Notifly\Commands
 */
class NotificationMakeCommand extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $name = 'notifly:make:notification';

    /**
     * @var string
     */
    protected $description = 'Create a new notification class';

    /**
     * @var string
     */
    protected $type = 'Notification';

    /**
     * @return bool|null
     * @throws FileNotFoundException
     */
    public function handle()
    {
        $response = parent::handle();
        if ($this->option('icon')) {
            $name = sprintf("%sIcon", $this->getNameInput());
            Artisan::call(sprintf("notifly:make:icon %s", $name));
        }

        return $response;
    }

    /**
     * @inheritDoc
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/notification.stub';
    }

    /**
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Notifications';
    }

    /**
     * @param string $name
     * @return string
     * @throws FileNotFoundException
     */
    protected function buildClass($name)
    {
        $verb = $this->getVerb($name);

        return str_replace(
            'DummyVerb',
            $verb,
            parent::buildClass($name)
        );
    }

    /**
     * @return array
     */
    protected function getArguments()
    {
        $arguments = [
            ['verb', InputArgument::OPTIONAL, 'The name of the notification verb'],
        ];

        return array_merge(parent::getArguments(), $arguments);
    }

    /**
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['icon', 'i', InputOption::VALUE_NONE, 'Create an icon class for the created notification class.'],
        ];
    }

    /**
     * @param $name
     * @return array|string|null
     */
    protected function getVerb($name)
    {
        $verb = $this->argument('verb');

        return $verb ? trim($verb) : Str::before(Str::snake(class_basename($name)), '_');
    }
}
