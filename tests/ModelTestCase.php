<?php

namespace Tests;

use Tests\TestCase;
use Tests\TestsHelpers\DataTransferObjects\ModelConfigurationAssertionParamsDto;

abstract class ModelTestCase extends TestCase
{
    protected function runConfigurationAssertions(ModelConfigurationAssertionParamsDto $dto): void
    {
        $this->assertEquals($dto->fillable, $dto->model->getFillable());
        $this->assertEquals($dto->guarded, $dto->model->getGuarded());
        $this->assertEquals($dto->hidden, $dto->model->getHidden());
        $this->assertEquals($dto->visible, $dto->model->getVisible());
        $this->assertEquals($dto->casts, $dto->model->getCasts());
        $this->assertEquals($dto->dates, $dto->model->getDates());
        $this->assertEquals($dto->primaryKey, $dto->model->getKeyName());

        $collection = $dto->model->newCollection();

        $this->assertEquals($dto->collectionClass, get_class($collection));

        if ($dto->table !== null) {
            $this->assertEquals($dto->table, $dto->model->getTable());
        }
    }
}
