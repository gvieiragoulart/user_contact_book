<?php

namespace Core\Domain\Exception;

use Exception;
use Throwable;
use Symfony\Component\HttpFoundation\Response;

class NotFoundException extends Exception
{
    public function __construct(string $message = "Contact not found",
    int $code = Response::HTTP_NOT_FOUND,
    Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
