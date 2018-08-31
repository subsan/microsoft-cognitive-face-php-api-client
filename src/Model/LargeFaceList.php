<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

use Subsan\MicrosoftCognitiveFace\Client;
use Subsan\MicrosoftCognitiveFace\Entity\FaceRectangle;
use Subsan\MicrosoftCognitiveFace\Entity\PersistedFace;
use Subsan\MicrosoftCognitiveFace\Model;

class LargeFaceList extends Model
{
    use CRUDTrait, TrainingTrait, ListedTrait;

    protected $baseUrl         = 'largefacelists';
    protected $entityClassName = \Subsan\MicrosoftCognitiveFace\Entity\LargeFaceList::class;

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
     * @return \Subsan\MicrosoftCognitiveFace\Entity|\Subsan\MicrosoftCognitiveFace\Entity\PersistedFace
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function getFace(string $faceId)
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/' . $this->partId . '/persistedFaces/' . $faceId);

        return (new PersistedFace())->import(json_decode((string)$response->getBody()));
    }

    /**
     * @param int|null    $top
     * @param string|null $start
     *
     * @return PersistedFace[]
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function listFace(int $top = null, string $start = null): array
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/' . $this->partId . '/persistedFaces',
            null,
            array(
                'start' => $start,
                'top'   => $top
            ));

        $list = json_decode((string)$response->getBody());

        foreach ($list as &$item) {
            $item = (new PersistedFace())->import($item);
        }

        return $list;
    }
}
