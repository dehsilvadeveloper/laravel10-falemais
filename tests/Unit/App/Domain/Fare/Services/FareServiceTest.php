<?php

namespace Tests\Unit\App\Domain\Fare\Services;

use Tests\TestCase;
use Exception;
use Mockery;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use App\Domain\Fare\Models\Fare;
use App\Domain\Fare\Repositories\FareRepositoryInterface;
use App\Domain\Fare\Services\Interfaces\FareServiceInterface;

class FareServiceTest extends TestCase
{
    /** @var FareServiceInterface */
    private $service;

    private $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repositoryMock = Mockery::mock(FareRepositoryInterface::class);
        $this->service = app(FareServiceInterface::class, ['fareRepository' => $this->repositoryMock]);
    }

    /**
     * @group services
     * @group fare
     */
    public function test_can_get_list_of_records(): void
    {
        $recordsCount = 3;
        $generatedRecords = Fare::factory()->count($recordsCount)->make();
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn($generatedRecords);

        $records = $this->service->getAll();
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['ddd_origin'], $recordsAsArray[$i]['ddd_origin']);
            $this->assertEquals(
                $generatedRecordsAsArray[$i]['ddd_destination'],
                $recordsAsArray[$i]['ddd_destination']
            );
            $this->assertEquals(
                $generatedRecordsAsArray[$i]['price_per_minute'],
                $recordsAsArray[$i]['price_per_minute']
            );
        }
    }

    /**
     * @group services
     * @group fare
     */
    public function test_can_get_empty_list_of_records(): void
    {
        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andReturn(new Collection());

        $records = $this->service->getAll();

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }

    /**
     * @group services
     * @group fare
     */
    public function test_generates_log_if_cannot_get_list(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Houston, we have a problem.');

        Log::shouldReceive('error')
            ->withArgs(function ($message, $context) {
                return strpos($message, 'Failed to get list of fares.') !== false
                    && strpos($context['message'], 'Houston, we have a problem.') !== false;
            });

        $this->repositoryMock
            ->shouldReceive('getAll')
            ->once()
            ->andThrows(new Exception('Houston, we have a problem.'));

        $this->service->getAll();
    }
}
