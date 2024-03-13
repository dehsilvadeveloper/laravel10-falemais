<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeServiceCommand extends GeneratorCommand
{
    /**
     * Use examples:
     *
     * php artisan make:service UserService
     * php artisan make:service Domain/User/Services/UserService
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Service';

    protected function getStub(): string
    {
        return base_path('stubs/service.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if ($this->nameContainNamespace()) {
            return $rootNamespace;
        }

        return $rootNamespace . '\Services';
    }

    private function nameContainNamespace(): bool
    {
        $name = trim($this->argument('name'));
        $name = str_replace('/', '\\', $name); // Convert forward slashes to namespace separators

        return (strpos($name, '\\') !== false);
    }
}
