<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeveloperRepository")
 */
class Developer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=63)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $hourlyWork;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="developer")
     */
    private $tasks;

    private ?Task $currentTask = null;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getHourlyWork(): ?int
    {
        return $this->hourlyWork;
    }

    public function setHourlyWork(int $hourlyWork): self
    {
        $this->hourlyWork = $hourlyWork;

        return $this;
    }

    public function getTasks(): iterable
    {
        return $this->tasks;
    }

    public function setTasks(ArrayCollection $tasks): void
    {
        $this->tasks = $tasks;
    }

    /**
     * @return Task|null
     */
    public function getCurrentTask(): ?Task
    {
        return $this->currentTask;
    }

    /**
     * @param Task|null $currentTask
     * @return $this
     */
    public function setCurrentTask(?Task $currentTask): self
    {
        $this->currentTask = $currentTask;

        return $this;
    }

    public function work(int $hours=1): void
    {
        $this->currentTask->decreaseWorkload($by=$this->hourlyWork * $hours);
    }
}
