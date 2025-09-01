<?php

declare(strict_types=1);

namespace CodingTask\Stream;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final readonly class Streamer
{
    public function streamToFile(ResponseStreamInterface $stream, string $filename): void
    {
        $out = fopen($filename, 'wb');

        if ($out === false) {
            throw new FilesystemException('Failed to open file for writing');
        }

        foreach ($stream as $chunk) {
            try {
                $data = $chunk->getContent();
            } catch (TransportExceptionInterface $e) {
                throw new NetworkException('Failed to read response', previous: $e);
            }

            fwrite($out, $data);
        }

        fclose($out);
    }
}
