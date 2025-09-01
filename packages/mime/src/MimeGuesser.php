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


        $mimeType = new MimeTypes()->guessMimeType($filename);

        if ($mimeType === null) {
            throw new UnknownMimeTypeException(sprintf(
                'Could not guess mime type for file "%s"',
                $filename
            ));
        }

        return $mimeType;
    }
}
