<?php

namespace Dvomaks\PromuaApi\Exceptions;

use Exception;

class PromuaApiException extends Exception
{
    protected array $errorDetails;

    public function __construct(string $message, int $code = 0, ?Exception $previous = null, array $errorDetails = [])
    {
        parent::__construct($message, $code, $previous);
        $this->errorDetails = $errorDetails;
    }

    public function getErrorDetails(): array
    {
        return $this->errorDetails;
    }
}