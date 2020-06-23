<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

final class Command extends \Symfony\Component\Console\Command\Command
{
    protected static $defaultName = 'run:symfony';

    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $exampleClient)
    {
        parent::__construct();
        $this->client = $exampleClient;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->client->request('GET', 'symfony/symfony/master/.gitignore');

        $output->writeln($response->getContent());

        return 0;
    }
}
