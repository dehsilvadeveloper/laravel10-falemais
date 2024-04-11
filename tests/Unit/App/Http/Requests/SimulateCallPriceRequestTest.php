<?php

namespace Tests\Unit\App\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\SimulateCallPriceRequest;
use Database\Seeders\PlanSeeder;

class SimulateCallPriceRequestTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(PlanSeeder::class);
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_pass_with_valid_request(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertFalse($validator->fails());
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_missing_required_fields(): void
    {
        $data = [];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(4, $validator->errors());
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_type_ddd_origin(): void
    {
        $data = [
            'ddd_origin' => 111,
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('ddd_origin'));

        $expectedMessages = [
            'The ddd origin field must be a string.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('ddd_origin')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_max_size_ddd_origin(): void
    {
        $data = [
            'ddd_origin' => '011011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('ddd_origin'));

        $expectedMessages = [
            'The ddd origin field must not be greater than 3 characters.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('ddd_origin')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_min_size_ddd_origin(): void
    {
        $data = [
            'ddd_origin' => '01',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('ddd_origin'));

        $expectedMessages = [
            'The ddd origin field must be at least 3 characters.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('ddd_origin')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_type_ddd_destination(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => 111,
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('ddd_destination'));

        $expectedMessages = [
            'The ddd destination field must be a string.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('ddd_destination')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_max_size_ddd_destination(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017017',
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('ddd_destination'));

        $expectedMessages = [
            'The ddd destination field must not be greater than 3 characters.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('ddd_destination')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_min_size_ddd_destination(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '01',
            'call_minutes' => 80,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('ddd_destination'));

        $expectedMessages = [
            'The ddd destination field must be at least 3 characters.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('ddd_destination')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_type_call_minutes(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 'invalid-type',
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('call_minutes'));

        $expectedMessages = [
            'The call minutes field must be an integer.',
            'The call minutes field must be greater than 0.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('call_minutes')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_size_call_minutes(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 0,
            'plan_id' => 2
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('call_minutes'));

        $expectedMessages = [
            'The call minutes field must be greater than 0.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('call_minutes')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_type_plan_id(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 'invalid-type'
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('plan_id'));

        $expectedMessages = [
            'The plan id field must be an integer.',
            'The plan id field must be greater than 0.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('plan_id')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_invalid_size_plan_id(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 0
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('plan_id'));

        $expectedMessages = [
            'The plan id field must be greater than 0.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('plan_id')
        );
    }

    /**
     * @group requests
     * @group simulation
     */
    public function test_fail_with_nonexistent_plan_id(): void
    {
        $data = [
            'ddd_origin' => '011',
            'ddd_destination' => '017',
            'call_minutes' => 80,
            'plan_id' => 999
        ];

        $request = (new SimulateCallPriceRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('plan_id'));

        $expectedMessages = [
            'The selected plan id is invalid.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('plan_id')
        );
    }
}
