<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Throwable;

#[AsCommand(
    name: 'app:test-db-connection',
    description: 'Testing database connection.',
)]
class TestDbConnectionCommand extends Command
{
    public function __construct(
        private readonly Connection $connection,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {

            $this->connection->connect();
            $dbName = $this->connection->getDatabase();
            $params = $this->connection->getParams();

            if ($this->connection->isConnected()) {
                $io->success('Connected to database ' . $dbName . ' successfully.');
                $io->writeln('→ Host : ' . ($params['host'] ?? 'N/A'));
                $io->writeln('→ Port : ' . ($params['port'] ?? 'N/A'));
                return Command::SUCCESS;
            }

            $io->error('Database connection failed.');
            return Command::FAILURE;

        } catch (Throwable $e) {
            $io->error('Error during database connexion : ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
