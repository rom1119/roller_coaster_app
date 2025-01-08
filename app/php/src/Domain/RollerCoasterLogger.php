<?php

declare(strict_types=1);

namespace App\Domain;

use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class RollerCoasterLogger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function logError(string $msg, array $context = []): void
    {
        $this->logger->error($msg, $context);
    }
}
