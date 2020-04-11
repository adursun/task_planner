<?php

namespace App\Model;

class BusinessTask
{
    private string $id;

    private int $level;

    private int $estimated_duration;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getLevel(): int
    {
        return $this->level;
    }

    /**
     * @param int $level
     */
    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    /**
     * @return int
     */
    public function getEstimatedDuration(): int
    {
        return $this->estimated_duration;
    }

    /**
     * @param int $estimated_duration
     */
    public function setEstimatedDuration(int $estimated_duration): void
    {
        $this->estimated_duration = $estimated_duration;
    }
}
