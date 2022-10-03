<?php

declare(strict_types=1);

namespace App\Core\Domain\Service;

use Symfony\Component\Validator\Constraints\Ulid;

class UlidService
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}