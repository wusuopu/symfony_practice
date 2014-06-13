<?php

namespace Blogger\BlogBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Doctrine\Common\Annotations\AnnotationRegistry;

class BloggerBlogBundle extends Bundle
{
    public function boot()
    {
        //parent::boot();

        //$kernel = $this->container->get('kernel');

        //AnnotationRegistry::registerFile(
            //$kernel->locateResource("@BloggerBlogBundle/Annotation/MyCustomAnnotation.php")
        //);
        //AnnotationRegistry::registerFile(
            //$kernel->locateResource("@BloggerBlogBundle/Annotation/Permissions.php")
        //);
    }
}
