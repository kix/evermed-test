<?php

declare(strict_types=1);

namespace CodingTask\Download\Tests;

use CodingTask\Download\Adapter\AdapterInterface;
use CodingTask\Download\Downloader;
use CodingTask\Download\Exception\UnsupportedUrlException;
use CodingTask\Download\Tests\Stub\ExampleAdapter;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;

final class DownloaderTest extends TestCase
{
    #[Test]
    public function itThrowsForUnsupportedUrls(): void
    {
        $downloader = new Downloader([
            new ExampleAdapter(),
        ]);

        $this->expectException(UnsupportedUrlException::class);
        $this->expectExceptionMessage('No adapter supports the URL "https://drive.google.com/file/d/1234567890/view".');

        $downloader->download('https://drive.google.com/file/d/1234567890/view');
    }

    #[Test]
    public function itCallsHighestPriorityAdapterFirst(): void
    {
        $adapterToBeCalled = $this->getMockBuilder(AdapterInterface::class)->getMock();
        $adapterToBeCalled
            ->expects($this->once())
            ->method('supports')
            ->with('https://example.com')
            ->willReturn(true)
        ;

        $adapterNotToBeCalled = $this->getMockBuilder(AdapterInterface::class)->getMock();
        $adapterNotToBeCalled
            ->expects($this->never())
            ->method('supports')
        ;

        $downloader = new Downloader([
            0 => $adapterNotToBeCalled,
            10 => $adapterToBeCalled,
        ], httpClient: new MockHttpClient());

        $downloader->download('https://example.com');
    }

    #[Test]
    #[Group('integration')]
    public function itDownloadsFilesViaHttp(): void
    {
        $downloader = Downloader::create();
        $file = $downloader->download('https://github.com/symfony/symfony/raw/refs/heads/7.4/README.md');

        self::assertEquals('text/html', $file->getMimeType());
        self::assertEquals('README.md', $file->getClientOriginalName());
        self::assertStringContainsString(
            '[Symfony][1] is a **PHP framework** for web and console applications',
            $file->getContent()
        );
    }
}
