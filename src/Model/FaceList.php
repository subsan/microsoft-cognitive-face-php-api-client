<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

use Subsan\MicrosoftCognitiveFace\Client;
use Subsan\MicrosoftCognitiveFace\Entity\FaceRectangle;
use Subsan\MicrosoftCognitiveFace\Model;

class FaceList extends Model
{
    use CRUDTrait, ListedTrait;

    protected $baseUrl         = 'facelists';
    protected $entityClassName = \Subsan\MicrosoftCognitiveFace\Entity\FaceList::class;

    private $partId;

    public function __construct(Client $client, string $partId = null)
    {
        $this->partId = $partId;

        parent::__construct($client);
    }

    /**
     * @param string             $url
     * @param string|null        $userData
     * @param FaceRectangle|null $targetFace
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function addFace(string $url, string $userData = null, FaceRectangle $targetFace = null)
    {
        $parameters = [
            'url' => $url
        ];

        $formParameters = [
            'userData'   => $userData,
            'targetFace' => (string)$targetFace
        ];


        $response = $this->client->request('POST', $this->baseUrl . '/' . $this->partId . '/persistedFaces', $parameters, $formParameters);

        return json_decode((string)$response->getBody());
    }

    /**
     * @param string $faceId
     *
     * @return bool
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function deleteFace(string $faceId): bool
    {
        $this->client->request('DELETE', $this->baseUrl . '/' . $this->partId . '/persistedFaces/' . $faceId);

        return true;
    }
}
