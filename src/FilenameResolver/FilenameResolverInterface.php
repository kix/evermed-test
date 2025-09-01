<?php

declare(strict_types=1);

namespace CodingTask\Download\FilenameResolver;

use Symfony\Contracts\HttpClient\ResponseInterface;

interface FilenameResolverInterface
{
    public function resolveFilename(ResponseInterface $response, string $fallbackUrl): string;
}
