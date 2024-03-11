<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeRepositoryCommand extends GeneratorCommand
{
    /**
     * Use examples:
     *
     * php artisan make:repository UserRepository
     * php artisan make:repository Domain/User/Repositories/UserRepository
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    protected function getStub(): string
    {
        return base_path('stubs/repository.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if ($this->nameContainNamespace()) {
            return $rootNamespace;
        }

        return $rootNamespace . '\Repositories';
    }

    private function nameContainNamespace(): bool
    {
        $name = trim($this->argument('name'));
        $name = str_replace('/', '\\', $name); // Convert forward slashes to namespace separators

        return (strpos($name, '\\') !== false);
    }
}
