<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

trait TrainingTrait
{
    /**
     * @return mixed
     */
    public function train()
    {
        $response = $this->client->request(
            'POST',
            $this->baseUrl . '/' . $this->partId . '/train'
        );

        return json_decode((string)$response->getBody());
    }

    /**
     * @return bool|mixed
     */
    public function getTrainStatus()
    {
        try {
            $response = $this->client->request(
                'GET',
                $this->baseUrl . '/' . $this->partId . '/training'
            );
        } catch (\Subsan\MicrosoftCognitiveFace\Exception\ClientException $e) {
            if ($e->getCodeName() === 'PersonGroupNotTrained') {
                return false;
            }
        }

        return json_decode((string)$response->getBody());
    }
}
