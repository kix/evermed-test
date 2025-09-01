<?php

declare(strict_types=1);

namespace CodingTask\Download;

final readonly class DownloaderConfig
{
    public function __construct(
        public int $fileSizeLimit = 1024 * 1024 * 10,
        public int $timeout = 30,
        public string $filenamePrefix = 'downloaded_',
    ) {}
}
