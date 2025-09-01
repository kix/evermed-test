<?php

declare(strict_types=1);

namespace CodingTask\Download\Adapter;

final readonly class OneDriveAdapter implements AdapterInterface
{
    public function supports(string $url): bool
    {
        return str_contains($url, '1drv.ms') || str_contains($url, 'onedrive.live.com');
    }

    public function resolve(string $url): string
    {
        return sprintf(
            'https://api.onedrive.com/v1.0/shares/u!%s/root/content',
            rtrim(strtr(base64_encode($url), '+/', '-_'), '=')
        );
    }
}
