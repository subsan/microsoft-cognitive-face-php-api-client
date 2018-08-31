<?php

namespace Subsan\MicrosoftCognitiveFace\Exception;

class ClientException extends \Exception
{
    /**
     * @var string
     */
    private $codeName;

    public function getCodeName()
    {
        return $this->codeName;
    }

    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        $json = json_decode($message);

        $this->codeName = $json->error->code;

        parent::__construct($json->error->message, $code, $previous);
    }
}
