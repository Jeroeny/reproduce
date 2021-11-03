<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Cache\CacheInterface;

#[AsCommand(name: 'run')]
final class Run extends Command
{
    public function __construct(private CacheInterface $cache)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $timeout    = time() + 30;
        $lastOutput = 0;
        while (time() < $timeout) {
            $this->cache->get((string)random_int(0, PHP_INT_MAX), function () {
                $values = [];
                $rand   = (string)random_int(0, PHP_INT_MAX);
                foreach ($this->getItems() as $k => $i) {
                    $values[] = $this->cache->get(
                        'composer.lock.' . $rand . '.' . $k,
                        fn () => file_get_contents(__DIR__ . '/../composer.lock')
                    );
                }

                return $values;
            });

            if ($lastOutput < time() - 1) {
                $lastOutput = time();
                $this->writeMem($output);
                $cycles = gc_collect_cycles();
                if ($cycles > 0) {
                    $output->writeln('Cleaned cycles: ' . $cycles);
                }
            }
        }

        return 0;
    }

    private function getItems(): \Generator
    {
        foreach (range(0, 30) as $i) {
            yield $this->cache->get('composer.lock.' . $i, fn () => file_get_contents(__DIR__ . '/../composer.lock'));
        }
    }

    private function writeMem(OutputInterface $output)
    {
        $output->writeln('Memory: ' . (memory_get_usage(false) / 1024 / 1024) . ' MB');
    }
}
