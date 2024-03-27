<?php

namespace App\Domain\Common\ValueObjects;

use InvalidArgumentException;
use Illuminate\Http\Response;

class DddObject
{
    public function __construct(private string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function validate(string $value): void
    {
        if (!is_string($value) || strlen($value) !== 3) {
            throw new InvalidArgumentException(
                'DDD must be a string of 3 characters.',
                Response::HTTP_BAD_REQUEST
            );
        }
    }
}
