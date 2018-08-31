<?php

namespace Subsan\MicrosoftCognitiveFace;

abstract class AbstractCRUDEntity extends Entity
{
    /**
     * @return mixed|null
     */
    abstract public function getCRUDBodyParameters();
}
