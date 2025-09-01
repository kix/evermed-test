<?php

declare(strict_types=1);

namespace CodingTask\Stream;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final readonly class Streamer
{
    public function __construct(
        private int $sizeLimit = 10_000_000
    ) {}

    public function streamToFile(ResponseStreamInterface $stream, string $filename): void
    {
        $out = fopen($filename, 'wb');

        if ($out === false) {
            throw new FilesystemException('Failed to open file for writing');
        }

        $filesize = 0;

        try {
            foreach ($stream as $chunk) {
                $data = $chunk->getContent();

                if ($filesize > $this->sizeLimit + strlen($data)) {
                    throw new FilesystemException(sprintf(
                        'Max file size of %d bytes exceeded',
                        $this->sizeLimit,
                    ));
                }

                $writtenBytes = fwrite($out, $data);

                if ($writtenBytes === false) {
                    throw new FilesystemException('Failed to write to file');
                }

                $filesize += $writtenBytes;
            }
        } catch (TransportExceptionInterface $e) {
            throw new NetworkException('Failed to read response', previous: $e);
        } finally {
            fclose($out);
        }
    }
}
