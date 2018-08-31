<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

use Subsan\MicrosoftCognitiveFace\Client;
use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;
use Subsan\MicrosoftCognitiveFace\Model;

abstract class AbstractGroup extends Model
{
    use TrainingTrait, ListedTrait, CRUDTrait;

    protected $baseUrl         = '';
    protected $entityClassName = '';

    private $partId;

    public function __construct(Client $client, string $partId = null)
    {
        $this->partId = $partId;

        parent::__construct($client);
    }

    /**
     * @param AbstractCRUDEntity $entity
     *
     * @return AbstractCRUDEntity
     * @throws \Subsan\MicrosoftCognitiveFace\Exception\ClientException
     */
    public function create(AbstractCRUDEntity $entity): AbstractCRUDEntity
    {
        $response = $this->client->request(
            'PUT',
            $this->baseUrl . '/' . $this->partId,
            $entity->getCRUDBodyParameters()
        );

        return $entity->import(json_decode((string)$response->getBody()));
    }

    /**
     * @param string|null $personId
     *
     * @return Person
     */
    public function person(string $personId = null): Person
    {
        return new Person($this->client, $this->baseUrl, $this->partId, $personId);
    }
}
