<?php

namespace App\Controller;

use App\Entity\Developer;
use App\Entity\Task;
use App\Repository\DeveloperRepository;
use App\Repository\TaskRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $em
     * @param DeveloperRepository $developerRepository
     * @param TaskRepository $taskRepository
     * @return Response
     */
    public function index(EntityManagerInterface $em, DeveloperRepository $developerRepository, TaskRepository $taskRepository)
    {
        $taskRepository->resetAll();

        /** @var Developer[] $developers */
        $developers = $developerRepository->findBy([], [
            'hourlyWork' => 'DESC',
        ]);

        // trying new criteria api
        $tasksCriteria = new Criteria();
        $tasksCriteria->where(Criteria::expr()->neq('remainingWorkload', 0))->orderBy([
            'workload' => 'DESC',
        ]);
        /** @var Task[] $tasks */
        $tasks = $taskRepository->matching($tasksCriteria)->toArray();

        $week = 0;

        while (count($developers) > 0) {
            $week++;

            for ($i = 0; $i < 45; $i++) {
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

        $em->flush();

        $resultingTasks = $taskRepository->findBy([], [
            'workload' => 'DESC',
            'startWeek' => 'ASC',
            'endWeek' => 'ASC',
        ]);

        return $this->render('home/index.html.twig', [
            'tasks' => $resultingTasks,
        ]);
    }
}
