<?php

namespace Subsan\MicrosoftCognitiveFace\Model;

/**
 * @method \Subsan\MicrosoftCognitiveFace\Entity\LargePersonGroup[] list(int | null $top, string | null $startu)
 */
class LargePersonGroup extends AbstractGroup
{
    protected $baseUrl         = 'largepersongroups';
    protected $entityClassName = \Subsan\MicrosoftCognitiveFace\Entity\LargePersonGroup::class;
}
