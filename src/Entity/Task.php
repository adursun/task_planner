<?php

namespace App\Entity;

use App\Model\TaskInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 * @ORM\Table(indexes={@Index(name="sort_idx", columns={"workload"})})
 */
class Task
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="integer")
     */
    private int $workload;

    /**
     * @ORM\Column(type="integer")
     */
    private int $remainingWorkload;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Developer", inversedBy="tasks")
     */
    private Developer $developer;

    /**
     * @ORM\Column(type="integer")
     */
    private int $startWeek = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private int $endWeek = 0;

    public function __construct(TaskInterface $taskInterface)
    {
        $this->name = $taskInterface->getName();
        $this->workload = $taskInterface->getWorkload();
        $this->remainingWorkload = $this->workload;
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

    public function getWorkload(): ?int
    {
        return $this->workload;
    }

    public function setWorkload(int $workload): self
    {
        $this->workload = $workload;

        return $this;
    }

    public function getRemainingWorkload(): int
    {
        return $this->remainingWorkload;
    }

    public function setRemainingWorkload(int $remainingWorkload): void
    {
        $this->remainingWorkload = $remainingWorkload;
    }

    public function decreaseRemainingWorkload(int $by): self
    {
        $this->remainingWorkload -= $by;

        if ($this->remainingWorkload < 0) {
            $this->remainingWorkload = 0;
        }

        return $this;
    }

    public function isFinished(): bool
    {
        return $this->remainingWorkload <= 0;
    }

    public function getDeveloper(): Developer
    {
        return $this->developer;
    }

    public function setDeveloper(Developer $developer): void
    {
        $this->developer = $developer;
    }

    public function getStartWeek(): ?int
    {
        return $this->startWeek;
    }

    public function setStartWeek(int $startWeek): self
    {
        $this->startWeek = $startWeek;

        return $this;
    }

    public function getEndWeek(): ?int
    {
        return $this->endWeek;
    }

    public function setEndWeek(int $endWeek): self
    {
        $this->endWeek = $endWeek;

        return $this;
    }
}
