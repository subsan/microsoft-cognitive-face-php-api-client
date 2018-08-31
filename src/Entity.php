<?php

namespace Subsan\MicrosoftCognitiveFace;

use Subsan\MicrosoftCognitiveFace\Exception\EntityException;

abstract class Entity
{
    /**
     * @param string $method
     * @param null   $params
     *
     * @return $this
     * @throws EntityException
     */
    public function __call(string $method, $params = null)
    {
        $methodPrefix = substr($method, 0, 3);
        $property     = lcfirst(substr($method, 3));

        if (property_exists($this, $property)) {
            switch ($methodPrefix) {
                case 'set':
                    $value             = $params[0];
                    $this->{$property} = $value;

                    return $this;
                case 'get':
                    return $this->{$property};
            }
        }

        throw new EntityException("Method $method is not defined in " . \get_class($this), 501);
    }

    /**
     * Call $this->>set{ParameterNameForCamelCaseMethodName} for all raw elements
     *
     * @param $raw
     *
     * @return $this
     */
    public function import($raw): self
    {
        foreach ((array)$raw as $property => $value) {
            $this->{'set' . implode(array_map('ucfirst', explode('_', $property)))}($value);
        }

        return $this;
    }
}
