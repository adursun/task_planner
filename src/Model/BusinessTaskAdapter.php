<?php

namespace App\Model;

class BusinessTaskAdapter implements TaskInterface
{
    private BusinessTask $businessTask;

    public function __construct(BusinessTask $businessTask)
    {
        $this->businessTask = $businessTask;
    }

    public function getName(): string
    {
        return $this->businessTask->getId();
    }

    public function getWorkload(): int
    {
        return $this->businessTask->getEstimatedDuration() * $this->businessTask->getLevel();
    }
}
