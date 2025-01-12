<?php

declare(strict_types=1);

namespace App\Domain;

interface StatisticMonitoring
{
    public function runMonitoring();

    public function emitEvent(DomainEvent $event);
}
