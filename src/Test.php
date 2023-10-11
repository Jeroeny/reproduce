<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\VarDumper\VarDumper;

#[AsCommand(name: 'test')]
final class Test extends Command
{
    public function __construct(private SerializerInterface&NormalizerInterface&DenormalizerInterface $serializer)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $l = '  =========  ';

        $output->writeln($l.'testXml'.$l);
        $this->testXml();

        return 0;
    }

    private function testXml(): void
    {
        $test = new Xml(null);
        $serialized = $this->serializer->serialize($test, XmlEncoder::FORMAT);
        $deserialized = $this->serializer->deserialize($serialized, Xml::class, XmlEncoder::FORMAT);
        VarDumper::dump($deserialized);
    }
}
