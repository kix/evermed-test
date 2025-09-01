<?php

declare(strict_types=1);

namespace CodingTask\Download\Tests;

use CodingTask\Download\Downloader;
use CodingTask\Download\Exception\UnsupportedUrlException;
use CodingTask\Download\Tests\Stub\ExampleAdapter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class DownloaderTest extends TestCase
{
    #[Test]
    public function itThrowsForUnsupportedUrls(): void
    {
        $downloader = new Downloader([
            new ExampleAdapter()
        ]);

        $this->expectException(UnsupportedUrlException::class);
        $this->expectExceptionMessage('No adapter supports the URL "https://drive.google.com/file/d/1234567890/view".');

        $downloader->download('https://drive.google.com/file/d/1234567890/view');
    }
}
