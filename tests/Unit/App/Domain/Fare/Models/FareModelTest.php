<?php

namespace Tests\Unit\App\Domain\Fare\Models;

use Tests\ModelTestCase;
use Tests\TestsHelpers\DataTransferObjects\ModelConfigurationAssertionParamsDto;
use App\Domain\Fare\Models\Fare;

class FareModelTest extends ModelTestCase
{
    /**
     * @group fare
     */
    public function test_has_valid_configuration(): void
    {
        $dto = ModelConfigurationAssertionParamsDto::from([
            'model'=> new Fare(),
            'fillable' => ['ddd_origin', 'ddd_destination', 'price_per_minute'],
            'casts' => ['price_per_minute' => 'float']
        ]);
        
        $this->runConfigurationAssertions($dto);
    }
}
