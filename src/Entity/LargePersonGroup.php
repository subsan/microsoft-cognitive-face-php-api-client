<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;

/**
 * @method LargePersonGroup setLargePersonGroupId(string $largePersonGroupId)
 * @method string getLargePersonGroupId()
 * @method LargePersonGroup setName(string $name)
 * @method string getName()
 * @method LargePersonGroup setUserData(string $userData)
 * @method string getUserData()
 */
class LargePersonGroup extends AbstractCRUDEntity
{
    /**
     * @var string Id of the target large person group
     */
    protected $largePersonGroupId;

    /**
     * @var string Large person group's display name
     */
    protected $name;

    /**
     * @var string User-provided data attached to this large person group
     */
    protected $userData;

    public function __construct(string $largePersonGroupId = null, string $name = null, string $userData = null)
    {
        $this->setLargePersonGroupId($largePersonGroupId)->setName($name)->setUserData($userData);
    }

    public function getCRUDBodyParameters()
    {
        return [
            'name'     => $this->getName(),
            'userData' => $this->getUserData()
        ];
    }
}
