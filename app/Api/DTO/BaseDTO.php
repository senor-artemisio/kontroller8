<?php

namespace App\Api\DTO;

/**
 * Base for data transfer object.
 */
abstract class BaseDTO
{
    /**
     * @param array $attributes
     * @throws DTOException
     */
    public function __construct(array $attributes)
    {
        foreach ($attributes as $name => $value) {
            $setter = camel_case("set_$name");
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            } else {
                throw new DTOException($name);
            }
        }
    }

    /**
     * @return array
     */
    abstract public function getChangedAttributes(): array;
}