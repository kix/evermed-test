<?php

declare(strict_types=1);

namespace CodingTask\Download;

use CodingTask\Download\Adapter\AdapterInterface;
use CodingTask\Download\Adapter\DirectHttpAdapter;
use CodingTask\Download\Adapter\GoogleDriveAdapter;
use CodingTask\Download\Adapter\OneDriveAdapter;
use CodingTask\Download\Exception\BadResponseException;
use CodingTask\Download\Exception\RequestFailedException;
use CodingTask\Download\Exception\UnsupportedUrlException;
use CodingTask\Download\FilenameResolver\FilenameResolver;
use CodingTask\Mime\MimeGuesser;
use CodingTask\Stream\Streamer;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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

    private HttpClientInterface $httpClient;

    /**
     * Usage:
     * Either pass an indexed array where the index is an integer, where the higher the index, the sooner the adapter is
     * tried, or pass the adapters as an unindexed array where the further the adapter is, the sooner it is tried.
     *
     * @param array<int, AdapterInterface> $adapters
     */
    public function __construct(
        array $adapters,
        ?HttpClientInterface $httpClient = null,
        private Streamer $streamer = new Streamer(),
        private MimeGuesser $mimeGuesser = new MimeGuesser(),
        private FilenameResolver $filenameResolver = new FilenameResolver(),
        private ?string $tmpPath = null,
    ) {
        krsort($adapters, SORT_NUMERIC);

        if ($httpClient === null) {
            $httpClient = HttpClient::create();
        }

        $this->httpClient = $httpClient;

        if ($this->tmpPath === null) {
            $this->tmpPath = sys_get_temp_dir();
        }

        foreach ($adapters as $priority => $adapter) {
            $this->registerAdapter($priority, $adapter);
        }
    }

    public static function create(DownloaderConfig $config = new DownloaderConfig()): self
    {
        return new self(
            [
                new GoogleDriveAdapter(),
                new OneDriveAdapter(),
                new DirectHttpAdapter(),
            ],
            HttpClient::create([
                'timeout' => $config->timeout,
            ]),
            new Streamer(sizeLimit: $config->fileSizeLimit),
            filenameResolver: new FilenameResolver($config->filenamePrefix),
        );
    }

    private function registerAdapter(int $priority, AdapterInterface $adapter): void
    {
        $this->adapters[$priority] = $adapter;
    }

    public function download(string $url): UploadedFile
    {
        $actualUrl = $this->resolveUrl($url);

        try {
            $response = $this->httpClient->request('GET', $actualUrl);
            $statusCode = $response->getStatusCode();
        } catch (TransportExceptionInterface $e) {
            throw new RequestFailedException(sprintf(
                'Failed to download file from "%s". Error: %s',
                $actualUrl,
                $e->getMessage()
            ), previous: $e);
        }

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new BadResponseException(sprintf(
                'Failed to download file from "%s". Status code: %d',
                $actualUrl,
                $statusCode
            ));
        }

        $stream = $this->httpClient->stream($response);
        $tmpFilename = $this->tmpPath . '/' . uniqid('coding-task-download-', true);
        $this->streamer->streamToFile($stream, $tmpFilename);
        $mime = $this->mimeGuesser->guess($tmpFilename);
        $originalName = $this->filenameResolver->resolveFilename($response, $url);

        return new UploadedFile($tmpFilename, $originalName, $mime);
    }

    private function resolveUrl(string $url): string
    {
        foreach ($this->adapters as $adapter) {
            if ($adapter->supports($url)) {
                return $adapter->resolve($url);
            }
        }

        throw UnsupportedUrlException::forUrl($url);
    }
}
