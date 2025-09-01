<?php

declare(strict_types=1);

namespace CodingTask\Download;

use CodingTask\Download\Adapter\AdapterInterface;

final readonly class Downloader
{
    public function registerAdapter(int $priority, AdapterInterface $adapter): void
    {

    }
}
