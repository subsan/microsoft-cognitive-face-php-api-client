<?php

namespace Subsan\MicrosoftCognitiveFace\Entity;

use Subsan\MicrosoftCognitiveFace\Entity;

/**
 * @method FaceRectangle setLeft(string $left)
 * @method int getLeft()
 * @method FaceRectangle setTop(string $top)
 * @method int getTop()
 * @method FaceRectangle setWidth(string $width)
 * @method int getWidth()
 * @method FaceRectangle setHeight(string $height)
 * @method int getHeight()
 */
class FaceRectangle extends Entity
{
    /**
     * @var int
     */
    protected $left;

    /**
     * @var int
     */
    protected $top;

    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    public function __toString()
    {
        return $this->getLeft() . ',' . $this->getTop() . ',' . $this->getWidth() . ',' . $this->getHeight();
    }
}
