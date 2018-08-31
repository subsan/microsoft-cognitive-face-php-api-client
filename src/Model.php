<?php

namespace Subsan\MicrosoftCognitiveFace;

class Model
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
