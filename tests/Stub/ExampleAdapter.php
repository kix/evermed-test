<?php

declare(strict_types=1);

namespace CodingTask\Download\Tests\Stub;

use CodingTask\Download\Adapter\AdapterInterface;

final readonly class ExampleAdapter implements AdapterInterface
{
    public function supports(string $url): bool
    {
        return $url === 'https://example.com/';
    }

    public function resolve(string $url): string
    {
        return '';
    }
}
