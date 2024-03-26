<?php

namespace Tests\Unit\App\Domain\Fare\Repositories\Eloquent;

use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Domain\Fare\Models\Fare;
use App\Domain\Fare\Repositories\FareRepositoryInterface;

class FareRepositoryEloquentTest extends TestCase
{
    /** @var FareRepositoryInterface */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(FareRepositoryInterface::class);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_create(): void
    {
        $data = [
            'ddd_origin' => str_pad(fake()->areaCode(), 3, '0', STR_PAD_LEFT),
            'ddd_destination' => str_pad(fake()->areaCode(), 3, '0', STR_PAD_LEFT),
            'price_per_minute' => fake()->randomFloat(2, 1, 9999.99)
        ];

        $createdRecord = $this->repository->create($data);

        $this->assertInstanceOf(Fare::class, $createdRecord);
        $this->assertDatabaseHas('fares', $data);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_update(): void
    {
        $existingRecord = Fare::factory()->create([
            'ddd_origin' => str_pad(fake()->areaCode(), 3, '0', STR_PAD_LEFT),
            'ddd_destination' => str_pad(fake()->areaCode(), 3, '0', STR_PAD_LEFT),
            'price_per_minute' => fake()->randomFloat(2, 1, 9999.99)
        ]);

        $dataForUpdate = [
            'ddd_origin' => '021',
            'ddd_destination' => '055',
            'price_per_minute' => 2.80
        ];

        $updatedRecord = $this->repository->update($existingRecord->id, $dataForUpdate);

        $this->assertInstanceOf(Fare::class, $updatedRecord);
        $this->assertEquals($existingRecord->id, $updatedRecord->id);
        $this->assertEquals($dataForUpdate['ddd_origin'], $updatedRecord->ddd_origin);
        $this->assertEquals($dataForUpdate['ddd_destination'], $updatedRecord->ddd_destination);
        $this->assertEquals($dataForUpdate['price_per_minute'], $updatedRecord->price_per_minute);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_cannot_update_a_nonexistent_record(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $dataForUpdate = [
            'ddd_origin' => '021',
            'ddd_destination' => '055',
            'price_per_minute' => 2.80
        ];

        $this->repository->update(1, $dataForUpdate);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_delete_by_id(): void
    {
        $existingRecordData = [
            'ddd_origin' => str_pad(fake()->areaCode(), 3, '0', STR_PAD_LEFT),
            'ddd_destination' => str_pad(fake()->areaCode(), 3, '0', STR_PAD_LEFT),
            'price_per_minute' => fake()->randomFloat(2, 1, 9999.99)
        ];
        $existingRecord = Fare::factory()->create($existingRecordData);

        $deleteResult = $this->repository->deleteById($existingRecord->id);

        $this->assertTrue($deleteResult);
        $this->assertDatabaseMissing('fares', $existingRecordData);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_cannot_delete_by_id_a_nonexistent_record(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->deleteById(1);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_get_list_of_records(): void
    {
        $recordsCount = 3;

        $generatedRecords = Fare::factory()->count($recordsCount)->create();
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $records = $this->repository->getAll();
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['ddd_origin'], $recordsAsArray[$i]['ddd_origin']);
            $this->assertEquals($generatedRecordsAsArray[$i]['ddd_destination'], $recordsAsArray[$i]['ddd_destination']);
            $this->assertEquals(
                $generatedRecordsAsArray[$i]['price_per_minute'],
                $recordsAsArray[$i]['price_per_minute']
            );
        }
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_get_empty_list_of_records(): void
    {
        $records = $this->repository->getAll();

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_get_list_filtered_by_field(): void
    {
        $recordsCount = 3;

        $generatedRecords = Fare::factory()->count($recordsCount)->create([
            'ddd_origin' => '021'
        ]);
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $records = $this->repository->getByField('ddd_origin', '021');
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['ddd_origin'], $recordsAsArray[$i]['ddd_origin']);
            $this->assertEquals($generatedRecordsAsArray[$i]['ddd_destination'], $recordsAsArray[$i]['ddd_destination']);
            $this->assertEquals(
                $generatedRecordsAsArray[$i]['price_per_minute'],
                $recordsAsArray[$i]['price_per_minute']
            );
        }
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_get_empty_list_filtered_by_field(): void
    {
        $records = $this->repository->getByField('ddd_origin', '045');

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_find_by_id(): void
    {
        $existingRecord = Fare::factory()->create();

        $foundRecord = $this->repository->firstById($existingRecord->id);

        $this->assertInstanceOf(Fare::class, $foundRecord);
        $this->assertEquals($existingRecord->ddd_origin, $foundRecord->ddd_origin);
        $this->assertEquals($existingRecord->ddd_destination, $foundRecord->ddd_destination);
        $this->assertEquals($existingRecord->price_per_minute, $foundRecord->price_per_minute);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_cannot_find_by_id_a_nonexistent_record(): void
    {
        $foundRecord = $this->repository->firstById(1);

        $this->assertNull($foundRecord);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_find_by_field(): void
    {
        $existingRecord = Fare::factory()->create([
            'ddd_origin' => '011'
        ]);

        $foundRecord = $this->repository->firstByField('ddd_origin', '011');

        $this->assertInstanceOf(Fare::class, $foundRecord);
        $this->assertEquals($existingRecord->ddd_origin, $foundRecord->ddd_origin);
        $this->assertEquals($existingRecord->ddd_destination, $foundRecord->ddd_destination);
        $this->assertEquals($existingRecord->price_per_minute, $foundRecord->price_per_minute);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_cannot_find_by_field_a_nonexistent_record(): void
    {
        $foundRecord = $this->repository->firstByField('ddd_origin', '033');

        $this->assertNull($foundRecord);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_can_find_where(): void
    {
        $existingRecord = Fare::factory()->create([
            'ddd_origin' => '011',
            'ddd_destination' => '018'
        ]);

        $foundRecord = $this->repository->firstWhere([
            'ddd_origin' => '011',
            'ddd_destination' => '018'
        ]);

        $this->assertInstanceOf(Fare::class, $foundRecord);
        $this->assertEquals($existingRecord->ddd_origin, $foundRecord->ddd_origin);
        $this->assertEquals($existingRecord->ddd_destination, $foundRecord->ddd_destination);
        $this->assertEquals($existingRecord->price_per_minute, $foundRecord->price_per_minute);
    }

    /**
     * @group repositories
     * @group fare
     */
    public function test_cannot_find_where_a_nonexistent_record(): void
    {
        $foundRecord = $this->repository->firstWhere([
            'ddd_origin' => '998',
            'ddd_destination' => '999'
        ]);

        $this->assertNull($foundRecord);
    }
}
