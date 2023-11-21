<?php

declare(strict_types=1);

namespace App\Auth\Infrastructure\Console;

use App\Auth\Application\CommandBus\SignUpCommand;
use App\Auth\Application\CommandBus\SignUpHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateUserCommand extends Command
{
    protected static $defaultDescription = 'Creates a new user.';

    public function __construct(
        private readonly SignUpHandler $handler,
    ) {
        parent::__construct('auth:create-user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->handler->handle(
            new SignUpCommand(
                $input->getArgument('email'),
                $input->getArgument('password'),
            ),
        );

        return Command::SUCCESS;
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'User email.')
            ->addArgument('password', InputArgument::REQUIRED, 'User password.')
        ;
    }
}
