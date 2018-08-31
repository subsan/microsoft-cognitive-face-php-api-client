<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

trait ListedTrait
{
    /**
     * @param int|null    $top
     * @param string|null $start
     *
     * @return array
     */
    public function list(int $top = null, string $start = null): array
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl,
            null,
            array(
                'start' => $start,
                'top'   => $top
            ));

        $list = json_decode((string)$response->getBody());

        foreach ($list as &$item) {
            $item = (new $this->entityClassName())->import($item);
        }

        return $list;
    }
}
