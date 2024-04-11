<?php

namespace Tests\Unit\App\Domain\Auth\DataTransferObjects;

use Tests\TestCase;
use Spatie\LaravelData\Exceptions\CannotCreateData;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Domain\Auth\DataTransferObjects\SuccessfulAuthDto;

class SuccessfulAuthDtoTest extends TestCase
{
    /**
     * @group dtos
     * @group auth
     */
    public function test_can_create_from_array_with_snakecase_keys(): void
    {
        $data = [
            'access_token' => 'fake-token',
            'token_type' => 'Bearer',
            'expires_at' => now()->format('Y-m-d H:i:s')
        ];

        $dto = SuccessfulAuthDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(SuccessfulAuthDto::class, $dto);
        $this->assertEquals($data['access_token'], $dtoAsArray['access_token']);
        $this->assertEquals($data['token_type'], $dtoAsArray['token_type']);
        $this->assertEquals($data['expires_at'], $dtoAsArray['expires_at']);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_can_create_from_array_with_camelcase_keys(): void
    {
        $data = [
            'accessToken' => 'fake-token',
            'tokenType' => 'Bearer',
            'expiresAt' => now()->format('Y-m-d H:i:s')
        ];

        $dto = SuccessfulAuthDto::from($data);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(SuccessfulAuthDto::class, $dto);
        $this->assertEquals($data['accessToken'], $dtoAsArray['access_token']);
        $this->assertEquals($data['tokenType'], $dtoAsArray['token_type']);
        $this->assertEquals($data['expiresAt'], $dtoAsArray['expires_at']);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_cannot_create_from_empty_array(): void
    {
        $this->expectException(CannotCreateData::class);

        $dto = SuccessfulAuthDto::from([]);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_can_create_from_request(): void
    {
        $requestData = [
            'access_token' => 'fake-token',
            'token_type' => 'Bearer',
            'expires_at' => now()->format('Y-m-d H:i:s')
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = SuccessfulAuthDto::from($request);
        $dtoAsArray = $dto->toArray();

        $this->assertInstanceOf(SuccessfulAuthDto::class, $dto);
        $this->assertEquals($requestData['access_token'], $dtoAsArray['access_token']);
        $this->assertEquals($requestData['token_type'], $dtoAsArray['token_type']);
        $this->assertEquals($requestData['expires_at'], $dtoAsArray['expires_at']);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_cannot_create_from_empty_request(): void
    {
        $this->expectException(CannotCreateData::class);

        $request = Request::create('/dummy', 'POST', []);

        $dto = SuccessfulAuthDto::from([]);
    }

    /**
     * @group dtos
     * @group auth
     */
    public function test_cannot_create_from_request_with_invalid_values(): void
    {
        $this->expectException(ValidationException::class);

        $requestData = [
            'access_token' => 123.50,
            'token_type' => 123.50,
            'expires_at' => 123.50
        ];

        $request = Request::create('/dummy', 'POST', $requestData);

        $dto = SuccessfulAuthDto::from($request);
    }
}
