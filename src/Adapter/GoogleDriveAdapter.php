<?php

declare(strict_types=1);

namespace CodingTask\Download\Adapter;

final class GoogleDriveAdapter implements AdapterInterface
{
    public function supports(string $url): bool
    {
        preg_match('~/d/([^/]+)/~', $url, $m);

        return array_key_exists(1, $m);
    }

    public function resolve(string $url): string
    {
        preg_match('~/d/([^/]+)/~', $url, $m);

        return sprintf('https://drive.google.com/uc?id=%s&export=download', $m[1]);
    }
}
