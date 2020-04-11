<?php

namespace App\Model;

class ItTaskAdapter implements TaskInterface
{
    private ItTask $itTask;

    public function __construct(ItTask $itTask)
    {
        $this->itTask = $itTask;
    }

    public function getName(): string
    {
        return $this->itTask->getId();
    }

    public function getWorkload(): int
    {
        return $this->itTask->getZorluk() * $this->itTask->getSure();
    }
}
