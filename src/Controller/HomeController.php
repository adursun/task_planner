<?php

namespace App\Controller;

use App\Form\WeeklyWorkingHourType;
use App\Repository\TaskRepository;
use App\Service\TaskAssignerService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"GET", "POST"})
     * @param Request $request
     * @param TaskRepository $taskRepository
     * @param TaskAssignerService $taskAssigner
     * @return Response
     */
    public function home(Request $request, TaskRepository $taskRepository, TaskAssignerService $taskAssigner)
    {
        $weeklyWorkingHour = 45;

        $form = $this->createForm(WeeklyWorkingHourType::class, [
            'weeklyWorkingHour' => 45,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $weeklyWorkingHour = $formData['weeklyWorkingHour'];
        }

        $taskAssigner->assignTasks($weeklyWorkingHour);

        $tasks = $taskRepository->findBy([], [
            'workload' => 'DESC',
            'startWeek' => 'ASC',
            'endWeek' => 'ASC',
        ]);

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'tasks' => $tasks,
        ]);
    }
}
