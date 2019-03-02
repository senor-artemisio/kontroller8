<?php

namespace App\Api\DTO;

use Throwable;

class DTOException extends \Exception
{
    /**
     * @param string $attribute
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $attribute = '', int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Invalid attribute $attribute.", $code, $previous);
    }
}