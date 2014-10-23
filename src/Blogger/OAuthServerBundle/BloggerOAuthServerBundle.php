<?php

namespace Blogger\OAuthServerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Blogger\OAuthServerBundle\DependencyInjection\BloggerOAuthServerExtension;

class BloggerOAuthServerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function getContainerExtension()
    {
        if (null === $this->extension) {
            return new BloggerOAuthServerExtension();
        }

        return $this->extension;
    }
}
