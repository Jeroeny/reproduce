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
        $l = '  =========  ';
        $output->writeln($l. 'testUnionArray'.$l);
        $this->testUnionArray();

        $output->writeln($l.'testUnionValue'.$l);
        $this->testUnionValue();

        $output->writeln($l.'testNested'.$l);
        $this->testNested();

        $output->writeln($l.'testWithNull'.$l);
        $this->testWithNull();

        $output->writeln($l.'testRegular'.$l);
        $this->testRegular();

        return 0;
    }

    private function testUnionArray(): void
    {
        $test = new UnionArray([new \DateInterval('PT1S'), new \DateInterval('PT1S')]);
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, UnionArray::class);
        VarDumper::dump($denormalized);
    }

    private function testUnionValue(): void
    {
        $test = new UnionValue([new \DateTimeImmutable(), new \DateInterval('PT1S')]);
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, UnionValue::class);
        VarDumper::dump($denormalized);
    }

    private function testNested(): void
    {
        $test = new Nested([[new \DateTimeImmutable(), new \DateInterval('PT1S'), 'string']]);
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, Nested::class);
        VarDumper::dump($denormalized);
    }

    private function testWithNull(): void
    {
        $test = new WithNull([new \DateTimeImmutable(), null]);
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, WithNull::class);
        VarDumper::dump($denormalized);
    }

    private function testRegular(): void
    {
        $test = new Regular([new \DateTimeImmutable()]);
        $normalized = $this->serializer->normalize($test);
        $denormalized = $this->serializer->denormalize($normalized, Regular::class);
        VarDumper::dump($denormalized);
    }
}
