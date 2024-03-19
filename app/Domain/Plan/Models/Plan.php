<?php

namespace App\Domain\Plan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Database\Factories\PlanFactory;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'max_free_minutes'
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return PlanFactory::new();
    }
}
