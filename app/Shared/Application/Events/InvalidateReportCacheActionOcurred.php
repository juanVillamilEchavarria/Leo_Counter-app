<?php

namespace App\Shared\Application\Events;

use App\Shared\Domain\Contracts\EventContract;
use App\Shared\Domain\ValueObjects\Date;

final readonly class InvalidateReportCacheActionOcurred implements EventContract
{
    public function __construct(
        private string $key = 'reportes',
        private Date $date = new Date(new \DateTimeImmutable())
    )
    {
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @inheritDoc
     */
    public function ocurredOn(): Date
    {
        return $this->date;
    }
}
