<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\Entity;

/**
 * @method PersistedFace setPersistedFaceId(string $persistedFaceId)
 * @method string getPersistedFaceId()
 * @method PersistedFace setUserData(string $userData)
 * @method string getUserData()
 */
class PersistedFace extends Entity
{
    /**
     * @var string The persistedFaceId of the target face, which is persisted and will not expire
     */
    protected $persistedFaceId;

    /**
     * @var string User-provided data attached to the face
     */
    protected $userData;

    public function __construct(string $persistedFaceId = null, string $userData = null)
    {
        $this->setPersistedFaceId($persistedFaceId)->setUserData($userData);
    }
}
