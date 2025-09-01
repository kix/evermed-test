<?php

declare(strict_types=1);

namespace CodingTask\Download\FilenameResolver;

use cardinalby\ContentDisposition\ContentDisposition;
use InvalidArgumentException;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class FilenameResolver implements FilenameResolverInterface
{
    public function resolveFilename(ResponseInterface $response, string $fallbackUrl): string
    {
        try {
            $disposition = ContentDisposition::parse($response->getHeaders(false)['content-disposition'][0] ?? '');

            return $disposition->getFilename();
        } catch (InvalidArgumentException $e) {
            $path = parse_url($fallbackUrl, PHP_URL_PATH);
            $filename = $path ? basename($path) : null;
        }

        return $filename ?: uniqid('downloaded_', true);
    }
}