<?php

namespace Tests\Unit\App\Domain\Common\ValueObjects;

use Tests\TestCase;
use InvalidArgumentException;
use App\Domain\Common\ValueObjects\DddObject;

class DddObjectTest extends TestCase
{
    /**
     * @group value_objects
     */
    public function test_can_create_with_valid_ddd(): void
    {
        $ddd = new DddObject('021');

        $this->assertEquals('021', $ddd->value());
    }

    /**
     * @group value_objects
     */
    public function test_cannot_create_from_invalid_length_ddd(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new DddObject('12');
    }

    /**
     * @group value_objects
     */
    public function test_cannot_create_from_invalid_type_ddd(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new DddObject((float) 12.5);
    }
}
