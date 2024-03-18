<?php

namespace Tests\Unit\App\Domain\Plan\Models;

use Tests\ModelTestCase;
use Tests\TestsHelpers\DataTransferObjects\ModelConfigurationAssertionParamsDto;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Domain\Plan\Models\Plan;

class PlanModelTest extends ModelTestCase
{
    use RefreshDatabase;

    /**
     * @group plan
     */
    public function test_has_valid_configuration(): void
    {
        $dto = ModelConfigurationAssertionParamsDto::from([
            'model'=> new Plan(),
            'fillable' => ['name', 'max_free_minutes']
        ]);
        
        $this->runConfigurationAssertions($dto);
    }
}
