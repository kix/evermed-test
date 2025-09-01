<?php

declare(strict_types=1);

namespace CodingTask\Download;

use CodingTask\Download\Adapter\AdapterInterface;
use CodingTask\Download\Adapter\DirectHttpAdapter;
use CodingTask\Download\Adapter\GoogleDriveAdapter;
use CodingTask\Download\Adapter\OneDriveAdapter;
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
     * Usage:
     * Either pass an indexed array where the index is an integer, where the higher the index, the sooner the adapter is
     * tried, or pass the adapters as an unindexed array where the further the adapter is, the sooner it is tried.
     *
     * @param array<int, AdapterInterface> $adapters
     */
    public function __construct(array $adapters)
    {
        krsort($adapters, SORT_NUMERIC);

        foreach ($adapters as $priority => $adapter) {
            $this->registerAdapter($priority, $adapter);
        }
    }

    public static function create(): self
    {
        return new self([
            new GoogleDriveAdapter(),
            new OneDriveAdapter(),
            new DirectHttpAdapter(),
        ]);
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
