<?php

namespace Tests\Unit\App\Domain\Auth\DataTransferObjects;

use Tests\TestCase;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use TypeError;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Domain\Auth\DataTransferObjects\LoginDto;

class LoginDtoTest extends TestCase
{
    /**
     * @group dtos
     * @group auth
     */
    public function test_can_create_from_array_with_snakecase_keys(): void
    {
        $data = [
            'email' => 'default@app.com',
            'password' => 'defaultpassword'
        ];

        $dto = LoginDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(LoginDto::class, $dto);
        $this->assertEquals($data['email'], $dtoAsArray['email']);
        $this->assertEquals($data['password'], $dtoAsArray['password']);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_can_create_from_array_with_camelcase_keys(): void
    {
        $data = [
            'email' => 'default@app.com',
            'password' => 'defaultpassword'
        ];

        $dto = LoginDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(LoginDto::class, $dto);
        $this->assertEquals($data['email'], $dtoAsArray['email']);
        $this->assertEquals($data['password'], $dtoAsArray['password']);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_cannot_create_from_empty_array(): void
    {
        $this->expectException(CannotCreateData::class);

        $dto = LoginDto::from([]);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_can_create_from_request(): void
    {
        $requestData = [
            'email' => 'default@app.com',
            'password' => 'defaultpassword'
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = LoginDto::from($request);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(LoginDto::class, $dto);
        $this->assertEquals($requestData['email'], $dtoAsArray['email']);
        $this->assertEquals($requestData['password'], $dtoAsArray['password']);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_cannot_create_from_empty_request(): void
    {
        $this->expectException(CannotCreateData::class);

        $request = Request::create('/dummy', 'POST', []);

        $dto = LoginDto::from([]);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_cannot_create_from_request_with_invalid_values(): void
    {
        $this->expectException(ValidationException::class);

        $requestData = [
            'email' => 123.50,
            'password' => 123.50
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = LoginDto::from($request);
    }
}
