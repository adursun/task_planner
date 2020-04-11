<?php

namespace App\Model;

interface TaskInterface
{
    public function getName() : string;

    public function getWorkload() : int;
}
