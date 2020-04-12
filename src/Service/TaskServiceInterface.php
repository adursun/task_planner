<?php

namespace App\Service;

use App\Entity\Task;

interface TaskServiceInterface
{
    /**
     * @return Task[]|array
     */
    public function getTasks();
}
