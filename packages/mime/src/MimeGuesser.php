<?php

declare(strict_types=1);

namespace CodingTask\Mime;

use Symfony\Component\Mime\MimeTypes;
use Symfony\Component\Mime\MimeTypesInterface;

final readonly class MimeGuesser
{
    public function __construct(
        private MimeTypesInterface $mimeTypes = new MimeTypes(),
        private bool $strict = true,
    ) {}

    public function guess(string $filename): string
    {
        if (!file_exists($filename)) {
            throw new FileNotFoundException(sprintf(
                'File "%s" does not exist',
                $filename
            ));
        }

        $mimeType = $this->mimeTypes->guessMimeType($filename);

        if ($mimeType === null && $this->strict) {
            throw new UnknownMimeTypeException(sprintf(
                'Could not guess mime type for file "%s"',
                $filename
            ));
        }

        return 'application/octet-stream';
    }
}
