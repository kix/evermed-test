<?php

declare(strict_types=1);

namespace CodingTask\Download\Tests;

use CodingTask\Download\Adapter\AdapterInterface;
use CodingTask\Download\Downloader;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DownloaderTest extends TestCase
{
    #[Test]
    public function itAcceptsAdapters(): void
    {
        $downloader = new Downloader();
        $downloader->registerAdapter(
            priority: 0,
            adapter: new class implements AdapterInterface {}
        );
    }
}
