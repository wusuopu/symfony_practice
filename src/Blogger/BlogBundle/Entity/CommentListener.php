<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping\PostPersist;
use Symfony\Component\HttpKernel\KernelInterface;
use Blogger\BlogBundle\Entity\Comment;

/**
 * 
 */
class CommentListener
{
    private $kernel;
    private $fields;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->fields = array();
    }

    public function preUpdate(PreUpdateEventArgs $event)
    {
        foreach ($event->getEntityChangeSet() as $field => $value) {
            array_push($this->fields, $field);
        }
        $entity = $event->getEntity();

        var_dump($this->fields, get_class($entity));
        if ($entity instanceof Comment) {
            // ... do something with the Product
        }
    }
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
