<?php

namespace App\Service;

use App\Entity\Task;

interface TaskServiceInterface
{
    /**
     * @return string
     */
    public function getContent();

    /**
     * @return Task[]|array
     */
    public function getTasks();
}
