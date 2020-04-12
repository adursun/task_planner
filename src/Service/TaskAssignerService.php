<?php

namespace App\Service;

use App\Entity\Developer;
use App\Entity\Task;
use App\Repository\DeveloperRepository;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class TaskAssignerService
{
    private EntityManagerInterface $em;

    private TaskRepository $taskRepository;

    private DeveloperRepository $developerRepository;

    public function __construct(EntityManagerInterface $em, TaskRepository $taskRepository, DeveloperRepository $developerRepository)
    {
        $this->em = $em;
        $this->taskRepository = $taskRepository;
        $this->developerRepository = $developerRepository;
    }

    public function assignTasks(int $weeklyWorkingHour=45): void
    {
        $this->taskRepository->resetAll();

        /** @var Developer[] $developers */
        $developers = $this->developerRepository->findBy([], [
            'hourlyWork' => 'DESC',
        ]);

        // trying new criteria api
        $tasksCriteria = new Criteria();
        $tasksCriteria->where(Criteria::expr()->neq('remainingWorkload', 0))->orderBy([
            'workload' => 'DESC',
        ]);
        /** @var Task[] $tasks */
        $tasks = $this->taskRepository->matching($tasksCriteria)->toArray();

        $week = 0;

        while (count($developers) > 0) {
            $week++;

            for ($i = 0; $i < $weeklyWorkingHour; $i++) {
                foreach ($developers as $developer) {
                    if ($developer->getCurrentTask() === null) {
                        $task = array_shift($tasks);

                        if ($task === null) {
                            $key = array_search($developer, $developers, true);
                            unset($developers[$key]);
                            continue;
                        } else {
                            $developer->setCurrentTask($task);
                            $task->setDeveloper($developer);
                            $task->setStartWeek($week);
                        }
                    }

                    $developer->work($hours=1);

                    if ($developer->getCurrentTask()->isFinished()) {
                        $developer->getCurrentTask()->setEndWeek($week);
                        $developer->setCurrentTask(null);
                    }
                }
            }
        }

        $this->em->flush();
    }
}
