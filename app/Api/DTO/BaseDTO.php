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
     * @return array not empty values of changeable attributes
     */
    public function getChangedValues(): array
    {
        $attributes = [];
        foreach ($this->getChangeableAttributes() as $attribute) {
            if ($this->$attribute !== null) {
                $attributes[snake_case($attribute)] = $this->$attribute;
            }
        }

        return $attributes;
    }

    /**
     * @return array list of changeable attributes
     */
    abstract protected function getChangeableAttributes():array;
}