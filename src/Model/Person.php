<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

use Subsan\MicrosoftCognitiveFace\Client;
use Subsan\MicrosoftCognitiveFace\Entity\FaceRectangle;
use Subsan\MicrosoftCognitiveFace\Model;

/**
 * @method \Subsan\MicrosoftCognitiveFace\Entity\Person[] list(int | null $top, string | null $startu)
 */
class Person extends Model
{
    use ListedTrait, CRUDTrait;

    private $baseUrl;
    private $groupId;
    private $partId;

    protected $entityClassName = \Subsan\MicrosoftCognitiveFace\Entity\Person::class;

    public function __construct(Client $client, string $baseUrl, string $groupId, string $partId = null)
    {
        $this->groupId  = $groupId;
        $this->baseUrl  = $baseUrl . '/' . $this->groupId . '/persons';
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
     * @param string $userData
     *
     * @return mixed
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function updateFace(string $faceId, string $userData)
    {
        $formParameters = [
            'userData' => $userData
        ];

        $response = $this->client->request('PATCH', $this->baseUrl . '/' . $this->partId . '/persistedFaces/' . $faceId, null, $formParameters);

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

    /**
     * @param string $faceId
     *
     * @return \Subsan\MicrosoftCognitiveFace\Entity|\Subsan\MicrosoftCognitiveFace\Entity\PersistedFace
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function getFace(string $faceId)
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/' . $this->partId . '/persistedFaces/' . $faceId);

        return (new \Subsan\MicrosoftCognitiveFace\Entity\PersistedFace())->import(json_decode((string)$response->getBody()));
    }
}
