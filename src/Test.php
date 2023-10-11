<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\VarDumper\VarDumper;

#[AsCommand(name: 'test')]
final class Test extends Command
{
    public function __construct(private NormalizerInterface&DenormalizerInterface $serializer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $test = new Working(new \DateInterval('PT1S'));
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, Working::class);
        VarDumper::dump($denormalized);

        $test = new Broken(new \DateTimeImmutable());
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, Broken::class);
        VarDumper::dump($denormalized);

        return 0;
    }
}
