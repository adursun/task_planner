<?php

namespace App\Command;

use App\Entity\Task;
use App\Model\BusinessTaskAdapter;
use App\Model\ItTaskAdapter;
use App\Service\BusinessTaskService;
use App\Service\ItTaskService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CollectTasksCommand extends Command
{
    private EntityManagerInterface $em;

    private ItTaskService $itTasksService;

    private BusinessTaskService $businessTasksService;

    protected static $defaultName = 'app:collect_tasks';

    public function __construct(EntityManagerInterface $em, ItTaskService $itTasksService, BusinessTaskService $businessTasksService)
    {
        $this->em = $em;
        $this->itTasksService = $itTasksService;
        $this->businessTasksService = $businessTasksService;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Collects tasks from external services');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $itTasks = $this->itTasksService->getTasks();

        foreach ($itTasks as $itTask) {
            $taskAdapter = new ItTaskAdapter($itTask);
            $task = new Task($taskAdapter);
            $this->em->persist($task);
        }

        $businessTasks = $this->businessTasksService->getTasks();

        foreach ($businessTasks as $businessTask) {
            $taskAdapter = new BusinessTaskAdapter($businessTask);
            $task = new Task($taskAdapter);
            $this->em->persist($task);
        }

        $this->em->flush();

        return 0;
    }
}
