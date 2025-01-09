<?php

declare(strict_types=1);

namespace App\Domain\Logger;

use Monolog\Handler\StreamHandler;
use Psr\Log\LoggerInterface;

class NotificationLogger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $notificationLogger)
    {
        $this->logger = $notificationLogger;
    }

    public function logEvent(string $msg, array $context = []): void
    {
        $this->logger->info($msg, $context);

    }
    
    public function logStatistics(array $statistics): void
    {
        $this->logger->info($msg, $context);

    }
}
