<?php

namespace Subsan\MicrosoftCognitiveFace;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Subsan\MicrosoftCognitiveFace\Model\Face;
use Subsan\MicrosoftCognitiveFace\Model\FaceList;
use Subsan\MicrosoftCognitiveFace\Model\LargeFaceList;
use Subsan\MicrosoftCognitiveFace\Model\LargePersonGroup;
use Subsan\MicrosoftCognitiveFace\Model\PersonGroup;

class Client
{
    private const BASE_URL = 'https://%s.api.cognitive.microsoft.com/face/v1.0/';

    private $guzzleClient;

    public function __construct(string $key, string $region = 'northeurope')
    {
        $this->guzzleClient = new \GuzzleHttp\Client([
            'base_uri' => sprintf(self::BASE_URL, $region),
            'headers'  => [
                'Ocp-Apim-Subscription-Key' => $key,
                'Content-Type'              => 'application/json',
                'User-Agent'                => 'subsan/microsoft-cognitive-face-php-api-client/1.0'
            ]
        ]);
    }

    /**
     * @param string     $method
     * @param string     $uri
     * @param array|null $formParameters
     * @param array|null $bodyParameters
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws Exception\ClientException
     */
    public function request(string $method, string $uri, array $bodyParameters = null, array $formParameters = null)
    {
        if (\is_array($bodyParameters)) {
            $parameters = [
                \GuzzleHttp\RequestOptions::BODY => json_encode($bodyParameters)
            ];
        } else {
            $parameters = array();
        }

        $responseUri = $uri;
        if (\is_array($formParameters)) {
            $params = array();

            foreach ($formParameters as $key => $value) {
                $params[] = $key . '=' . $value;
            }

            if ($params !== array()) {
                $responseUri .= '?' . implode($params, '&');
            }
        }

        try {
            return $this->guzzleClient->request($method, $responseUri, $parameters);
        } catch (GuzzleException $e) {
            /**
             * @var $e RequestException
             */
            throw new Exception\ClientException((string)$e->getResponse()->getBody(), $e->getCode(), $e);
        }
    }

    public function face(): Face
    {
        return new Face($this);
    }

    public function faceList(string $faceListId = null): FaceList
    {
        return new FaceList($this, $faceListId);
    }

    public function largeFaceList(string $largeFaceListId = null): LargeFaceList
    {
        return new LargeFaceList($this, $largeFaceListId);
    }

    public function personGroup(string $groupId = null): PersonGroup
    {
        return new PersonGroup($this, $groupId);
    }

    public function largePersonGroup(string $groupId = null): LargePersonGroup
    {
        return new LargePersonGroup($this, $groupId);
    }
}
