<?php

declare(strict_types=1);

namespace CodingTask\Download\Adapter;

/**
 * Adapter implementations are responsible for resolving download links into URLs that have the actual file content.
 */
interface AdapterInterface
{
    public function resolve(string $url): string;
}