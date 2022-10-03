<?php

declare(strict_types=1);

namespace App\Core\Application\Query;

interface QueryBusInterface
{
    public function execute(QueryInterface $query): mixed;
}