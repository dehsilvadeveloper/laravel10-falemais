<?php

namespace Tests\Unit\App\Http\Requests;

use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Api\LoginRequest;

class LoginRequestTest extends TestCase
{
    /**
     * @group requests
     * @group auth
     */
    public function test_pass_with_valid_request(): void
    {
        $data = [
            'email' => fake()->unique()->safeEmail(),
            'password' => fake()->password()
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertFalse($validator->fails());
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_missing_required_fields(): void
    {
        $data = [];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_invalid_type_email(): void
    {
        $data = [
            'email' => 123456,
            'password' => fake()->password()
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('email'));

        $expectedMessages = [
            'The email field must be a string.',
            'The email field must be a valid email address.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('email')
        );
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_invalid_min_size_email(): void
    {
        $data = [
            'email' => 'abc',
            'password' => fake()->password()
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('email'));

        $expectedMessages = [
            'The email field must be at least 6 characters.',
            'The email field must be a valid email address.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('email')
        );
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_invalid_max_size_email(): void
    {
        $data = [
            'email' => fake()->words(80, true),
            'password' => fake()->password()
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(2, $validator->errors());
        $this->assertTrue($validator->errors()->has('email'));

        $expectedMessages = [
            'The email field must not be greater than 70 characters.',
            'The email field must be a valid email address.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('email')
        );
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_invalid_email(): void
    {
        $data = [
            'email' => 'invalid_format_email',
            'password' => fake()->password()
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('email'));

        $expectedMessages = [
            'The email field must be a valid email address.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('email')
        );
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_invalid_type_password(): void
    {
        $data = [
            'email' => fake()->unique()->safeEmail(),
            'password' => 123456
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('password'));

        $expectedMessages = [
            'The password field must be a string.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('password')
        );
    }

    /**
     * @group requests
     * @group auth
     */
    public function test_fail_with_invalid_min_size_password(): void
    {
        $data = [
            'email' => fake()->unique()->safeEmail(),
            'password' => 'abc'
        ];

        $request = (new LoginRequest())->replace($data);
        $validator = Validator::make($data, $request->rules(), $request->messages());

        $this->assertTrue($validator->fails());
        $this->assertCount(1, $validator->errors());
        $this->assertTrue($validator->errors()->has('password'));

        $expectedMessages = [
            'The password field must be at least 6 characters.'
        ];

        $this->assertEquals(
            $expectedMessages,
            $validator->errors()->get('password')
        );
    }
}
