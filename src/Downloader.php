<?php

declare(strict_types=1);

namespace CodingTask\Download;

use CodingTask\Download\Adapter\AdapterInterface;
use CodingTask\Download\Exception\UnsupportedUrlException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Handles downloading files from various sources.
 *
 * The adapters are responsible for resolving download links into URLs that have the actual file content.
 * Adapters with highest priority are tried first.
 */
final class Downloader
{
    /**
     * @var array<int, AdapterInterface>
     */
    private array $adapters;

    /**
     * @param array<int, AdapterInterface> $adapters
     */
    public function __construct(array $adapters)
    {
        krsort($adapters, SORT_NUMERIC);

        foreach ($adapters as $priority => $adapter) {
            $this->registerAdapter($priority, $adapter);
        }
    }

    private function registerAdapter(int $priority, AdapterInterface $adapter): void
    {
        $this->adapters[$priority] = $adapter;
    }

    public function download(string $url): UploadedFile
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->supports($url)) {
                $resolvedUrl = $adapter->resolve($url);

                return new UploadedFile(__FILE__, 'test');
            }
        }

        throw UnsupportedUrlException::forUrl($url);
    }
}
