<?php

declare(strict_types=1);

namespace CodingTask\Download\Adapter;

final readonly class OneDriveAdapter implements AdapterInterface
{
    public function supports(string $url): bool
    {
        return false;
    }

    public function resolve(string $url): string
    {
        return '';
    }
}
