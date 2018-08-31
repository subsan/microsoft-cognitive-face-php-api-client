<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;

/**
 * @method Person setPersonId(string $personId)
 * @method string getPersonId()
 * @method Person setName(string $name)
 * @method string getName()
 * @method Person setUserData(string $userData)
 * @method string getUserData()
 * @method Person setPersistedFaceIds(string[] $persistedFaceIds)
 * @method string[] getPersistedFaceIds()
 */
class Person extends AbstractCRUDEntity
{
    /**
     * @var string Id of the retrieved person
     */
    protected $personId;

    /**
     * @var string Person's display name. The maximum length is 128.
     */
    protected $name;

    /**
     * @var string Optional fields for user-provided data attached to a person. Size limit is 16KB.
     */
    protected $userData;

    /**
     * @var array persistedFaceIds of registered faces in the person
     */
    protected $persistedFaceIds;

    public function __construct(string $personId = null, string $name = null, string $userData = null)
    {
        $this->setPersonId($personId)->setName($name)->setUserData($userData);
    }

    public function getCRUDBodyParameters()
    {
        return [
            'name'     => $this->getName(),
            'userData' => $this->getUserData()
        ];
    }
}
