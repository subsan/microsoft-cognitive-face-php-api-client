<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;

/**
 * @method LargeFaceList setLargeFaceListId(string $largeFaceListId)
 * @method string getLargeFaceListId()
 * @method LargeFaceList setName(string $name)
 * @method string getName()
 * @method LargeFaceList setUserData(string $userData)
 * @method string getUserData()
 */
class LargeFaceList extends AbstractCRUDEntity
{
    /**
     * @var string Id of the target large face list.
     */
    protected $largeFaceListId;

    /**
     * @var string Large face list's display name
     */
    protected $name;

    /**
     * @var string User-provided data attached to this face list
     */
    protected $userData;

    public function getCRUDBodyParameters()
    {
        return [
            'name'     => $this->getName(),
            'userData' => $this->getUserData()
        ];
    }
}
