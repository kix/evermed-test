<?php

declare(strict_types=1);

namespace CodingTask\Download\Adapter;

final readonly class DirectHttpAdapter implements AdapterInterface
{
    public function supports(string $url): bool
    {
        return str_starts_with($url, 'http://') || str_starts_with($url, 'https://');
    }

    public function resolve(string $url): string
    {
        return $url;
    }
}
