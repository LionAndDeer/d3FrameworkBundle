<?php

namespace Liondeer\Exception;

use Exception;
use JetBrains\PhpStorm\Pure;

class LiondeerD3FrameworkException extends Exception
{
    #[Pure]
    public function __construct(
        $message,
        $code,
        $previous = null
    ) {
        $message = "LiondeerD3FrameworkException: " . $message;
        parent::__construct($message, $code, $previous);
    }
}