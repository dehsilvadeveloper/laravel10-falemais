<?php

namespace Tests\Unit\App\Domain\Plan\Repositories\Eloquent;

use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Plan\Models\Plan;
use App\Domain\Plan\Repositories\PlanRepositoryInterface;

class PlanRepositoryEloquentTest extends TestCase
{
    /** @var PlanRepositoryInterface */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(PlanRepositoryInterface::class);
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_can_create(): void
    {
        $data = [
            'name' => fake()->word(),
            'max_free_minutes' => fake()->randomNumber(2)
        ];

        $createdRecord = $this->repository->create($data);

        $this->assertInstanceOf(Plan::class, $createdRecord);
        $this->assertDatabaseHas('plans', $data);
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_can_update(): void
    {
        $existingRecord = Plan::factory()->create([
            'name' => fake()->word(),
            'max_free_minutes' => fake()->randomNumber(2)
        ]);

        $dataForUpdate = [
            'name' => 'Updated name',
            'max_free_minutes' => 10
        ];

        $updatedRecord = $this->repository->update($existingRecord->id, $dataForUpdate);

        $this->assertInstanceOf(Plan::class, $updatedRecord);
        $this->assertEquals($existingRecord->id, $updatedRecord->id);
        $this->assertEquals($dataForUpdate['name'], $updatedRecord->name);
        $this->assertEquals($dataForUpdate['max_free_minutes'], $updatedRecord->max_free_minutes);
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_cannot_update_a_nonexistent_record(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $dataForUpdate = [
            'name' => 'Updated name',
            'max_free_minutes' => 10
        ];

        $this->repository->update(1, $dataForUpdate);
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_can_delete_by_id(): void
    {
        $existingRecordData = [
            'name' => fake()->word(),
            'max_free_minutes' => fake()->randomNumber(2)
        ];
        $existingRecord = Plan::factory()->create($existingRecordData);

        $deleteResult = $this->repository->deleteById($existingRecord->id);

        $this->assertTrue($deleteResult);
        $this->assertDatabaseMissing('plans', $existingRecordData);
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_cannot_delete_by_id_a_nonexistent_record(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->deleteById(1);
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_can_get_list_of_records(): void
    {
        $recordsCount = 3;

        $generatedRecords = Plan::factory()->count($recordsCount)->create();
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $records = $this->repository->getAll();
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['name'], $recordsAsArray[$i]['name']);
            $this->assertEquals(
                $generatedRecordsAsArray[$i]['max_free_minutes'],
                $recordsAsArray[$i]['max_free_minutes']
            );
        }
    }

    /**
     * @group repositories
     * @group plan
     */
    public function test_can_get_empty_list_of_records(): void
    {
        $records = $this->repository->getAll();

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }
}
