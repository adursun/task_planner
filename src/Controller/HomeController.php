<?php

namespace App\Controller;

use App\Repository\DeveloperRepository;
use App\Repository\TaskRepository;
use App\Service\TaskAssignerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param EntityManagerInterface $em
     * @param TaskRepository $taskRepository
     * @param TaskAssignerService $taskAssigner
     * @return Response
     */
    public function index(TaskRepository $taskRepository, TaskAssignerService $taskAssigner)
    {
        $taskAssigner->assignTasks();

        $tasks = $taskRepository->findBy([], [
            'workload' => 'DESC',
            'startWeek' => 'ASC',
            'endWeek' => 'ASC',
        ]);

        return $this->render('home/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }
}
