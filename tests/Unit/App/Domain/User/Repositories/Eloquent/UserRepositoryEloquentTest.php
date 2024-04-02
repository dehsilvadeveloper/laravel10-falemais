<?php

namespace Tests\Unit\App\Domain\User\Repositories\Eloquent;

use Tests\TestCase;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use App\Domain\User\Models\User;
use App\Domain\User\Repositories\UserRepositoryInterface;

class UserRepositoryEloquentTest extends TestCase
{
    /** @var UserRepositoryInterface */
    private $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = app(UserRepositoryInterface::class);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_create(): void
    {
        $data = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password')
        ];

        $createdRecord = $this->repository->create($data);

        $this->assertInstanceOf(User::class, $createdRecord);
        $this->assertDatabaseHas('users', $data);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_update(): void
    {
        $existingRecord = User::factory()->create([
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password')
        ]);

        $dataForUpdate = [
            'name' => 'Updated name',
            'email' => fake()->unique()->safeEmail(),
        ];

        $updatedRecord = $this->repository->update($existingRecord->id, $dataForUpdate);

        $this->assertInstanceOf(User::class, $updatedRecord);
        $this->assertEquals($existingRecord->id, $updatedRecord->id);
        $this->assertEquals($dataForUpdate['name'], $updatedRecord->name);
        $this->assertEquals($dataForUpdate['email'], $updatedRecord->email);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_cannot_update_a_nonexistent_record(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $dataForUpdate = [
            'name' => 'Updated name',
            'email' => fake()->unique()->safeEmail(),
        ];

        $this->repository->update(1, $dataForUpdate);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_delete_by_id(): void
    {
        $existingRecordData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password')
        ];
        $existingRecord = User::factory()->create($existingRecordData);

        $deleteResult = $this->repository->deleteById($existingRecord->id);

        $this->assertTrue($deleteResult);
        $this->assertDatabaseMissing('users', $existingRecordData);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_cannot_delete_by_id_a_nonexistent_record(): void
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->deleteById(1);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_get_list_of_records(): void
    {
        $recordsCount = 3;

        $generatedRecords = User::factory()->count($recordsCount)->create();
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $records = $this->repository->getAll();
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['name'], $recordsAsArray[$i]['name']);
            $this->assertEquals($generatedRecordsAsArray[$i]['email'], $recordsAsArray[$i]['email']);
        }
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_get_empty_list_of_records(): void
    {
        $records = $this->repository->getAll();

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_get_list_filtered_by_field(): void
    {
        $recordsCount = 3;
        $fakeName = fake()->name();

        $generatedRecords = User::factory()->count($recordsCount)->create([
            'name' => $fakeName
        ]);
        $generatedRecordsAsArray = $generatedRecords->toArray();

        $records = $this->repository->getByField('name', $fakeName);
        $recordsAsArray = $records->toArray();

        $this->assertCount($recordsCount, $records);

        for ($i = 0; $i <= ($recordsCount - 1); $i++) {
            $this->assertEquals($generatedRecordsAsArray[$i]['name'], $recordsAsArray[$i]['name']);
            $this->assertEquals($generatedRecordsAsArray[$i]['email'], $recordsAsArray[$i]['email']);
        }
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_get_empty_list_filtered_by_field(): void
    {
        $records = $this->repository->getByField('name', 'nonexistent name');

        $this->assertCount(0, $records);
        $this->assertTrue($records->isEmpty());
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_find_by_id(): void
    {
        $existingRecord = User::factory()->create();

        $foundRecord = $this->repository->firstById($existingRecord->id);

        $this->assertInstanceOf(User::class, $foundRecord);
        $this->assertEquals($existingRecord->name, $foundRecord->name);
        $this->assertEquals($existingRecord->email, $foundRecord->email);
        $this->assertEquals($existingRecord->password, $foundRecord->password);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_cannot_find_by_id_a_nonexistent_record(): void
    {
        $foundRecord = $this->repository->firstById(1);

        $this->assertNull($foundRecord);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_find_by_field(): void
    {
        $fakeName = fake()->name();
        $existingRecord = User::factory()->create([
            'name' => $fakeName
        ]);

        $foundRecord = $this->repository->firstByField('name', $fakeName);

        $this->assertInstanceOf(User::class, $foundRecord);
        $this->assertEquals($existingRecord->name, $foundRecord->name);
        $this->assertEquals($existingRecord->email, $foundRecord->email);
        $this->assertEquals($existingRecord->password, $foundRecord->password);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_cannot_find_by_field_a_nonexistent_record(): void
    {
        $foundRecord = $this->repository->firstByField('name', 'nonexistent name');

        $this->assertNull($foundRecord);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_can_find_where(): void
    {
        $existingRecordData = [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail()
        ];

        $existingRecord = User::factory()->create([
            'name' => $existingRecordData['name'],
            'email' => $existingRecordData['email']
        ]);

        $foundRecord = $this->repository->firstWhere([
            'name' => $existingRecordData['name'],
            'email' => $existingRecordData['email']
        ]);

        $this->assertInstanceOf(User::class, $foundRecord);
        $this->assertEquals($existingRecord->name, $foundRecord->name);
        $this->assertEquals($existingRecord->email, $foundRecord->email);
        $this->assertEquals($existingRecord->password, $foundRecord->password);
    }

    /**
     * @group repositories
     * @group user
     */
    public function test_cannot_find_where_a_nonexistent_record(): void
    {
        $foundRecord = $this->repository->firstWhere([
            'name' => 'Special',
            'email' => 'nonexistent@test.com'
        ]);

        $this->assertNull($foundRecord);
    }
}
