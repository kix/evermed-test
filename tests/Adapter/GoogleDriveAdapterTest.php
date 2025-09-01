<?php

declare(strict_types=1);

namespace Adapter;

use CodingTask\Download\Adapter\GoogleDriveAdapter;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

final class GoogleDriveAdapterTest extends TestCase
{
    #[Test]
    public function itReturnsValidGoogleDriveDownloadURLs(): void
    {
        $url = 'https://drive.google.com/file/d/1Dj5OdY2CCw0uMLO2WnEGubvNp0evtgwu/view?usp=drive_link';
        $adapter = new GoogleDriveAdapter();

        static::assertEquals(
            'https://drive.google.com/uc?id=1Dj5OdY2CCw0uMLO2WnEGubvNp0evtgwu&export=download',
            $adapter->resolve($url)
        );
    }
}