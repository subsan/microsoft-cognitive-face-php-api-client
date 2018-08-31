<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

/**
 * @method \Subsan\MicrosoftCognitiveFace\Entity\PersonGroup[] list(int | null $top, string | null $startu)
 */
class PersonGroup extends AbstractGroup
{
    protected $baseUrl         = 'persongroups';
    protected $entityClassName = \Subsan\MicrosoftCognitiveFace\Entity\PersonGroup::class;
}
