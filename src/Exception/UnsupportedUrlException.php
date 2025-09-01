<?php

declare(strict_types=1);

namespace CodingTask\Download\Exception;

use BadMethodCallException;

final class UnsupportedUrlException extends BadMethodCallException
{
    public static function forUrl(string $url): self
    {
        return new self(sprintf(
            'No adapter supports the URL "%s".',
            $url
        ));
    }
}
