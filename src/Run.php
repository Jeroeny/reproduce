<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;

#[AsCommand(name: 'run')]
final class Run extends Command
{
    public function __construct(private SerializerInterface $serializer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('BadOne: ' . $this->serializer->serialize(new BadOne(Uuid::v4()),'json'));
        $output->writeln('GoodOne: ' . $this->serializer->serialize(new GoodOne(Uuid::v4()),'json'));

        return 0;
    }
}
