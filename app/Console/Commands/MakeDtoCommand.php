<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeDtoCommand extends GeneratorCommand
{
    /**
     * Use examples:
     *
     * php artisan make:dto CreateUserDto
     * php artisan make:dto Domain/User/DataTransferObjects/CreateUserDto
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dto {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new DTO class.';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'DTO';

    protected function getStub(): string
    {
        return base_path('stubs/dto.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        if ($this->nameContainNamespace()) {
            return $rootNamespace;
        }

        return $rootNamespace . '\DataTransferObjects';
    }

    private function nameContainNamespace(): bool
    {
        $name = trim($this->argument('name'));
        $name = str_replace('/', '\\', $name); // Convert forward slashes to namespace separators

        return (strpos($name, '\\') !== false);
    }
}
