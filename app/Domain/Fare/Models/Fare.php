<?php

namespace App\Domain\Fare\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Database\Factories\FareFactory;

class Fare extends Model
{
    use HasFactory;

    protected $table = 'fares';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ddd_origin',
        'ddd_destination',
        'price_per_minute'
    ];
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Create a new factory instance for the model.
     */
    protected static function newFactory(): Factory
    {
        return FareFactory::new();
    }
}
