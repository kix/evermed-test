<?php

declare(strict_types=1);

namespace CodingTask\Download\FilenameResolver;

use cardinalby\ContentDisposition\ContentDisposition;
use InvalidArgumentException;
use Symfony\Contracts\HttpClient\ResponseInterface;

final readonly class FilenameResolver implements FilenameResolverInterface
{
    const string HEADER_CONTENT_DISPOSITION = 'content-disposition';
    const string FILE_PREFIX = 'downloaded_';

    public function resolveFilename(ResponseInterface $response, string $fallbackUrl): string
    {
        try {
            $disposition = ContentDisposition::parse($response->getHeaders(false)[self::HEADER_CONTENT_DISPOSITION][0] ?? '');

            return $disposition->getFilename();
        } catch (InvalidArgumentException $e) {
            $path = parse_url($fallbackUrl, PHP_URL_PATH);
            $filename = $path ? basename($path) : null;
        }

        return $filename ?: uniqid(self::FILE_PREFIX, true);
    }
}