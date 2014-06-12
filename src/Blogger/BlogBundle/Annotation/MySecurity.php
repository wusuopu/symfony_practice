<?php

namespace Blogger\BlogBundle\Annotation;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 **/
class MySecurity
{
    private $propertyName;
    private $dataType = 'string';

    public function __construct($options)
    {
        var_dump('in MySecurity');
        var_dump($options);
        if (isset($options['value'])) {
            $options['propertyName'] = $options['value'];
            unset($options['value']);
        }

        foreach ($options as $key => $value) {
            if (!property_exists($this, $key)) {
                throw new \InvalidArgumentException(sprintf('Property "%s" does not exist', $key));
            }

            $this->$key = $value;
        }
    }

    public function getPropertyName()
    {
        return $this->propertyName;
    }

    public function getDataType()
    {
        return $this->dataType;
    }   
}
