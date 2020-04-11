<?php

namespace App\Model;

class ItTask
{
    private string $id;

    private int $zorluk;

    private int $sure;

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
    public function getZorluk(): int
    {
        return $this->zorluk;
    }

    /**
     * @param int $zorluk
     */
    public function setZorluk(int $zorluk): void
    {
        $this->zorluk = $zorluk;
    }

    /**
     * @return int
     */
    public function getSure(): int
    {
        return $this->sure;
    }

    /**
     * @param int $sure
     */
    public function setSure(int $sure): void
    {
        $this->sure = $sure;
    }
}
