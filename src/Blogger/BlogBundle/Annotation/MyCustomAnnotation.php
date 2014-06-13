<?php

namespace Blogger\BlogBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 **/
class MyCustomAnnotation
{
    /**
     * @var string
     * Dummy field
     */
    private $field;

    /**
     * Get Dummy field
     * @return
     */
    public function getField()
    {
        return $this->field;
    }
}
