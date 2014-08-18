<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Mapping\PostPersist;

/**
 * 
 */
class CommentListener
{
    /**
     * @PostPersist
     */
    public function postPersistHandler(Comment $comment, LifecycleEventArgs $event)
    {
        $em = $event->getEntityManager();
        var_dump('postPersistHandler Comment');
        die();
    }
}
