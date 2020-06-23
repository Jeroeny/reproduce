<?php

declare(strict_types=1);

namespace App\Command;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PsrClientCommand extends Command
{
    protected static $defaultName = 'run:psr18';

    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        parent::__construct();
        $this->client = $client;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $response = $this->client->sendRequest(new Request(
                'GET',
                'https://raw.githubusercontent.com/symfony/symfony/master/.gitignore')
        );

        $response->getBody();

        return 0;
    }
}
