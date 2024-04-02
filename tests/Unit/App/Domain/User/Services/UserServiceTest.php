<?php

namespace Tests\Unit\App\Domain\User\Services;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Support\Facades\Log;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Services\Interfaces\UserServiceInterface;

class UserServiceTest extends TestCase
{
    /** @var UserServiceInterface */
    private $service;

    private $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(UserRepositoryInterface::class);
        $this->service = app(UserServiceInterface::class, ['userRepository' => $this->repositoryMock]);
    }

    /**
     * @group services
     * @group user
     */
    public function test_can_find_record_by_id(): void
    {
        $generatedRecord = User::factory()->make();
        $generatedRecord->id = 1;
        
        $this->repositoryMock
            ->shouldReceive('firstById')
            ->once()
            ->with($generatedRecord->id)
            ->andReturn($generatedRecord);

        $foundRecord = $this->service->firstById($generatedRecord->id);

        $this->assertInstanceOf(User::class, $foundRecord);
        $this->assertEquals($generatedRecord->name, $foundRecord->name);
        $this->assertEquals($generatedRecord->email, $foundRecord->email);
        $this->assertEquals($generatedRecord->password, $foundRecord->password);
    }

    /**
     * @group services
     * @group user
     */
    public function test_generates_log_if_exception_occurs_when_try_find_record_by_id(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Houston, we have a problem.');

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, '[UserService] Failed to find a user with the id provided.') !== false
                    && strpos($context['error_message'], 'Houston, we have a problem.') !== false;
            });

        $this->repositoryMock
            ->shouldReceive('firstById')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.'));

        $this->service->firstById(1);
    }

    /**
     * @group services
     * @group user
     */
    public function test_can_find_record_by_email(): void
    {
        $generatedRecord = User::factory()->make();
        $generatedRecord->id = 1;
        
        $this->repositoryMock
            ->shouldReceive('firstByField')
            ->once()
            ->with('email', $generatedRecord->email, ['id', 'name', 'email', 'password'])
            ->andReturn($generatedRecord);

        $foundRecord = $this->service->firstByEmail($generatedRecord->email);

        $this->assertInstanceOf(User::class, $foundRecord);
        $this->assertEquals($generatedRecord->name, $foundRecord->name);
        $this->assertEquals($generatedRecord->email, $foundRecord->email);
        $this->assertEquals($generatedRecord->password, $foundRecord->password);
    }

    /**
     * @group services
     * @group user
     */
    public function test_generates_log_if_exception_occurs_when_try_find_record_by_email(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Houston, we have a problem.');

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, '[UserService] Failed to find a user with the email provided.') !== false
                    && strpos($context['error_message'], 'Houston, we have a problem.') !== false;
            });

        $this->repositoryMock
            ->shouldReceive('firstByField')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.'));

        $this->service->firstByEmail('nonexistent@test.com');
    }
}
