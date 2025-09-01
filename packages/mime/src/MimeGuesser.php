<?php

declare(strict_types=1);

namespace CodingTask\Mime;

use Symfony\Component\Mime\MimeTypes;

final readonly class MimeGuesser
{
    public function guess(string $filename): string
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException(sprintf(
                'File "%s" does not exist',
                $filename
            ));
        }

        return new MimeTypes()->guessMimeType($filename);
    }
}
