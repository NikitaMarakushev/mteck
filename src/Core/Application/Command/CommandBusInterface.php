<?php

declare(strict_types=1);

namespace App\Core\Application\Command;

interface CommandBusInterface
{
    public function execute(CommandInterface $command): mixed;
}