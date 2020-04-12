<?php

namespace App\Command;

use App\Service\BusinessTaskService;
use App\Service\ItTaskService;
use App\Service\TaskServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CollectTasksCommand extends Command
{
    private EntityManagerInterface $em;

    /** @var TaskServiceInterface[] */
    private array $services;

    protected static $defaultName = 'app:collect_tasks';

    public function __construct(EntityManagerInterface $em, ItTaskService $itTasksService, BusinessTaskService $businessTasksService)
    {
        $this->em = $em;
        $this->services = [$itTasksService, $businessTasksService];

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Collects tasks from external services');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $taskCount = 0;

        foreach ($this->services as $service) {
            $tasks = $service->getTasks();
            $taskCount += count($tasks);

            foreach ($tasks as $task) {
                $this->em->persist($task);
            }
        }

        $this->em->flush();

        $output->writeln('<info>Collected '. $taskCount . ' tasks.</info>');

        return 0;
    }
}
