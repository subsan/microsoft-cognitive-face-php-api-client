<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;

/**
 * @method FaceList setFaceListId(string $faceListId)
 * @method string getFaceListId()
 * @method FaceList setName(string $name)
 * @method string getName()
 * @method FaceList setUserData(string $userData)
 * @method string getUserData()
 * @method PersistedFace[] getPersistedFaces()
 */
class FaceList extends AbstractCRUDEntity
{
    /**
     * @var string Id of the target face list
     */
    protected $faceListId;

    /**
     * @var string Face list's display name
     */
    protected $name;

    /**
     * @var string	User-provided data attached to this face list
     */
    protected $userData;

    /**
     * @var PersistedFace[] Faces in the face list
     */
    protected $persistedFaces;

    public function __construct(string $faceListId = null, string $name = null, string $userData = null)
    {
        $this->setFaceListId($faceListId)->setName($name)->setUserData($userData);
    }

    /**
     * @param PersistedFace[]|\stdClass[] $persistedFaces
     *
     * @return $this
     */
    public function setPersistedFaces(array $persistedFaces): self
    {
        $faces = array();
        foreach ($persistedFaces as $persistedFace) {
            if (!is_a($persistedFace, PersistedFace::class)) {
                $faces[] = (new PersistedFace())->import($persistedFace);
            } else {
                $faces[] = $persistedFace;
            }
        }
        $this->persistedFaces = $faces;

        return $this;
    }

    public function getCRUDBodyParameters()
    {
        return [
            'name'     => $this->getName(),
            'userData' => $this->getUserData()
        ];
    }
}
