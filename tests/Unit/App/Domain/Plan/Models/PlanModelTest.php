<?php

namespace Tests\Unit\App\Domain\Plan\Models;

use Tests\ModelTestCase;
use Tests\TestsHelpers\DataTransferObjects\ModelConfigurationAssertionParamsDto;
use App\Domain\Plan\Models\Plan;

class PlanModelTest extends ModelTestCase
{
    /**
     * @group plan
     */
    public function test_has_valid_configuration(): void
    {
        $dto = ModelConfigurationAssertionParamsDto::from([
            'model' => new Plan(),
            'fillable' => ['name', 'max_free_minutes'],
            'table' => 'plans'
        ]);

        $this->runConfigurationAssertions($dto);
    }
}
