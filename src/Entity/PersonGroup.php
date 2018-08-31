<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;

/**
 * @method PersonGroup setPersonGroupId(string $personGroupId)
 * @method string getPersonGroupId()
 * @method PersonGroup setName(string $name)
 * @method string getName()
 * @method PersonGroup setUserData(string $userData)
 * @method string getUserData()
 */
class PersonGroup extends AbstractCRUDEntity
{
    /**
     * @var string Target personGroupId provided in request parameter.
     */
    protected $personGroupId;

    /**
     * @var string Person group display name. The maximum length is 128.
     */
    protected $name;

    /**
     * @var string User-provided data attached to the person group. The size limit is 16KB.
     */
    protected $userData;

    public function __construct(string $personGroupId = null, string $name = null, string $userData = null)
    {
        $this->setPersonGroupId($personGroupId)->setName($name)->setUserData($userData);
    }

    public function getCRUDBodyParameters()
    {
        return [
            'name'     => $this->getName(),
            'userData' => $this->getUserData()
        ];
    }
}
