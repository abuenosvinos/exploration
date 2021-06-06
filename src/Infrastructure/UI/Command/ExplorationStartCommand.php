<?php

namespace App\Infrastructure\UI\Command;

use App\Infrastructure\UI\Command\Operation\LoadPlanetOperation;
use App\Infrastructure\UI\Command\Operation\NewMissionOperation;
use App\Infrastructure\UI\Command\Operation\Operation;
use App\Infrastructure\UI\Command\Operation\OperationNotAvailableException;
use App\Infrastructure\UI\Command\Operation\SendExplorerOperation;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExplorationStartCommand extends Command
{
    protected static $defaultName = 'app:exploration-start';

    private SymfonyStyle $io;
    private array $operations = [];
    private ContainerInterface $container;
    private NewMissionOperation $newMissionOperation;

    public function __construct(ContainerInterface $container, NewMissionOperation $newMissionOperation)
    {
        parent::__construct();

        $this->container = $container;
        $this->newMissionOperation = $newMissionOperation;
    }

    public function setOperations(iterable $operations)
    {
        foreach ($operations as $operation) {
            $this->operations[] = $operation;
        }
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Exploration Control')
            ->setHelp($this->getCommandHelp())
        ;
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     */
    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $actions = ['EXIT'];
        /** @var Operation $operation */
        foreach ($this->operations as $operation) {
            $actions = array_merge($actions, $operation->actions());
        }

        $this->newMissionOperation->run('NEW', $this->io);

        $question = new Question('> ');
        $question->setAutocompleterValues($actions);

        $helper = $this->getHelper('question');
        do {

            try {
                $answer = $helper->ask($input, $this->io, $question);

                if ($answer === null) {
                    throw new OperationNotAvailableException();
                }

                $attended = false;

                /** @var Operation $operation */
                foreach ($this->operations as $operation) {

                    if ($operation->attend($answer)) {
                        $operation->run($answer, $this->io);

                        $attended = true;
                        break;
                    }
                }

                if (!$attended && $this->isFinish($answer)) {
                    throw new OperationNotAvailableException();
                }

            } catch (\Throwable $e) {
                $this->io->warning($e->getMessage());
            }

        } while ($this->isFinish($answer));

        $this->io->success('Bye!');

        return Command::SUCCESS;
    }

    private function getCommandHelp(): string
    {
        return <<<'HELP'
The <info>%command.name%</info> command starts the navigation command to explore
HELP;
    }

    private function isFinish(string $input = null): bool {
        return ($input !== 'EXIT');
    }
}
