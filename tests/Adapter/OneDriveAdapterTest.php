<?php

declare(strict_types=1);

namespace Adapter;

use CodingTask\Download\Adapter\OneDriveAdapter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class OneDriveAdapterTest extends TestCase
{
    #[Test]
    public function itSupportsOneDriveUrls(): void
    {
        $adapter = new OneDriveAdapter();

        self::assertTrue(
            $adapter->supports('https://1drv.ms/b/c/8f4d753b56a799fe/ESKrqlN0ImdOrNp7nOV2EBMBzzMso6e1aE_RXldm19QxLg?e=0Xy1zJ')
        );
    }

    #[Test]
    public function itReturnsCorrectUrl(): void
    {
        $adapter = new OneDriveAdapter();
        $url = 'https://1drv.ms/b/c/8f4d753b56a799fe/ESKrqlN0ImdOrNp7nOV2EBMBzzMso6e1aE_RXldm19QxLg?e=0Xy1zJ';

        self::assertEquals(
            'https://api.onedrive.com/v1.0/shares/u!aHR0cHM6Ly8xZHJ2Lm1zL2IvYy84ZjRkNzUzYjU2YTc5OWZlL0VTS3JxbE4wSW1kT3JOcDduT1YyRUJNQnp6TXNvNmUxYUVfUlhsZG0xOVF4TGc_ZT0wWHkxeko/root/content',
            $adapter->resolve($url)
        );
    }
}
