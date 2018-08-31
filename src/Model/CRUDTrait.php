<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

use Subsan\MicrosoftCognitiveFace\AbstractCRUDEntity;

trait CRUDTrait
{
    /**
     * @param AbstractCRUDEntity $entity
     *
     * @return AbstractCRUDEntity
     */
    public function create(AbstractCRUDEntity $entity): AbstractCRUDEntity
    {
        $response = $this->client->request('POST', $this->baseUrl, $entity->getCRUDBodyParameters());

        return $entity->import(json_decode((string)$response->getBody()));
    }

    /**
     * @param AbstractCRUDEntity $entity
     *
     * @return AbstractCRUDEntity
     */
    public function update(AbstractCRUDEntity $entity): AbstractCRUDEntity
    {
        $response = $this->client->request('PATCH', $this->baseUrl . '/' . $this->partId, $entity->getCRUDBodyParameters());

        return $entity->import(json_decode((string)$response->getBody()));
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $this->client->request('DELETE', $this->baseUrl . '/' . $this->partId);

        return true;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/' . $this->partId);

        return (new $this->entityClassName())->import(json_decode((string)$response->getBody()));
    }
}
