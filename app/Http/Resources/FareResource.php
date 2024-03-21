<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FareResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'ddd_origin' => $this->ddd_origin,
            'ddd_destination' => $this->ddd_destination,
            'price_per_minute' => $this->price_per_minute
        ];
    }
}
