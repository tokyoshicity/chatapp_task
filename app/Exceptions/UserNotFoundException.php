<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = 'User not found',
        int $code = Response::HTTP_NOT_FOUND
    ) {
        parent::__construct($message, code: $code);
    }
}
