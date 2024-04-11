<?php

namespace Tests\Unit\App\Domain\User\Models;

use Tests\ModelTestCase;
use Tests\TestsHelpers\DataTransferObjects\ModelConfigurationAssertionParamsDto;
use App\Domain\User\Models\User;

class UserModelTest extends ModelTestCase
{
    /**
     * @group user
     */
    public function test_has_valid_configuration(): void
    {
        $dto = ModelConfigurationAssertionParamsDto::from([
            'model' => new User(),
            'fillable' => ['name', 'email', 'password'],
            'hidden' => ['password', 'remember_token'],
            'casts' => [
                'id' => 'int',
                'email_verified_at' => 'datetime',
                'password' => 'hashed'
            ],
            'table' => 'users'
        ]);

        $this->runConfigurationAssertions($dto);
    }
}
