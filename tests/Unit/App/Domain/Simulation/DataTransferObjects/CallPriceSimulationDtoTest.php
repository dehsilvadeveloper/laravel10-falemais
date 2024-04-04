<?php

namespace Tests\Unit\App\Domain\Simulation\DataTransferObjects;

use Tests\TestCase;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use TypeError;
use App\Domain\Common\ValueObjects\DddObject;
use App\Domain\Simulation\DataTransferObjects\CallPriceSimulationDto;

class CallPriceSimulationDtoTest extends TestCase
{
    /**
     * @group dtos
     * @group simulation
     */
    public function test_can_create_from_array_with_snakecase_keys(): void
    {
        $data = [
            'ddd_origin' => new DddObject('011'),
            'ddd_destination' => new DddObject('017'),
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $dto = CallPriceSimulationDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceSimulationDto::class, $dto);
        $this->assertEquals($data['ddd_origin'], $dtoAsArray['ddd_origin']);
        $this->assertEquals($data['ddd_destination'], $dtoAsArray['ddd_destination']);
        $this->assertEquals($data['call_minutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($data['plan_id'], $dtoAsArray['plan_id']);
    }

    /**
     * @group dtos
     * @group simulation
     */
    public function test_can_create_from_array_with_camelcase_keys(): void
    {
        $data = [
            'dddOrigin' => new DddObject('011'),
            'dddDestination' => new DddObject('017'),
            'callMinutes' => 80,
            'planId' => 2
        ];

        $dto = CallPriceSimulationDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(CallPriceSimulationDto::class, $dto);
        $this->assertEquals($data['dddOrigin'], $dtoAsArray['ddd_origin']);
        $this->assertEquals($data['dddDestination'], $dtoAsArray['ddd_destination']);
        $this->assertEquals($data['callMinutes'], $dtoAsArray['call_minutes']);
        $this->assertEquals($data['planId'], $dtoAsArray['plan_id']);
    }

    /**
     * @group dtos
     * @group simulation
     */
    public function test_cannot_create_from_empty_array(): void
    {
        $this->expectException(CannotCreateData::class);

        CallPriceSimulationDto::from([]);
    }

    /**
     * @group dtos
     * @group simulation
     */
    public function test_cannot_create_from_array_with_invalid_values(): void
    {
        $this->expectException(TypeError::class);

        $data = [
            'ddd_origin' => 'invalid value',
            'ddd_destination' => 'invalid value',
            'call_minutes' => 'invalid value',
            'plan_id' => 'invalid value'
        ];

        CallPriceSimulationDto::from($data);
    }

}
