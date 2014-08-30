<?php

namespace Blogger\BlogBundle\Common;

/**
 * 
 */
class ContainerBase
{
    private $container;
    
    function __construct()
    {
        global $kernel;
        $this->container = $kernel->getContainer();
    }

    public function getContainer()
    {
        return $this->container;
    }
}
