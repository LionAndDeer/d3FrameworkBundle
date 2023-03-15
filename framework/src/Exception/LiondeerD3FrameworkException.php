<?php

namespace Liondeer\Framework\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Yaml\Exception\ExceptionInterface;

class LiondeerD3FrameworkException extends Exception
{
    #[Pure]
    public function __construct(
        string $message = "",
        int $code = 0,
        ExceptionInterface $previous = null
    ) {
        $message = "LiondeerD3FrameworkException: " . $message;
        parent::__construct($message, $code, $previous);
    }
}