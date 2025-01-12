<?php

declare(strict_types=1);

namespace App\Domain\Model;

class CoasterID
{
    protected string $uuid;

    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function create(): self
    {
        return new self(uniqid());
    }

    public static function createFrom(string $uuid): self
    {
        return new self($uuid);
    }

    public function __serialize()
    {
        return
            [
                $this->uuid,
            ]
        ;
    }

    public function __unserialize(array $data)
    {
        $this->uuid = $data[0];
    }

    /**
     * Get the value of uuid.
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    public function __toString()
    {
        return $this->uuid;
    }
}
