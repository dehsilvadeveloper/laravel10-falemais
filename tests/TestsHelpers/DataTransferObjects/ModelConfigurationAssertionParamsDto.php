<?php

namespace Tests\TestsHelpers\DataTransferObjects;

use Spatie\LaravelData\Data;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModelConfigurationAssertionParamsDto extends Data
{
    public function __construct(
        public Model $model,
        public array $fillable = [],
        public array $hidden = [],
        public array $guarded = ['*'],
        public array $visible = [],
        public array $casts = ['id' => 'int'],
        public array $dates = ['created_at', 'updated_at'],
        public string $collectionClass = Collection::class,
        public ?string $table = null,
        public string $primaryKey = 'id'
    ) {
    }
}
