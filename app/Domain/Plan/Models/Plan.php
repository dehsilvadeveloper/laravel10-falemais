<?php

namespace App\Domain\Plan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
