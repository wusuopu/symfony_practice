<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PostFlushEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping\PostPersist;
use Doctrine\ORM\Mapping\PreUpdate;
use Doctrine\ORM\Mapping\PostUpdate;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Blogger\BlogBundle\Entity\Comment;


/**
 * 
 */
class CommentListener
{
    //private $kernel;
    private $fields = array();

    //public function __construct(KernelInterface $kernel)
    //{
        //$this->kernel = $kernel;
        //$this->fields = array();
    //}

    //public function preUpdate(PreUpdateEventArgs $event)
    //{
        //foreach ($event->getEntityChangeSet() as $field => $value) {
            //array_push($this->fields, $field);
        //}
        //$entity = $event->getEntity();

        //var_dump($this->fields, get_class($entity));
        //if ($entity instanceof Comment) {
            //// ... do something with the Product
        //}
    //}

    /**
     * @PreUpdate
     */
    public function preUpdateHandler(Comment $comment, PreUpdateEventArgs $event)
    {
        foreach ($event->getEntityChangeSet() as $field => $value) {
            array_push($this->fields, $field);
        }
        var_dump($this->fields, $comment->getComment());
    }

    /**
     * @PostUpdate
     */
    public function PostUpdateHandler(Comment $comment, LifecycleEventArgs $event)
    {
        var_dump("Post Update", $this->fields, $comment->getComment());
        global $kernel;
        var_dump($kernel->getContainer()->get('sso_response_listener'));
    }

    /**
     * @PostPersist
     */
    //public function postPersistHandler(Comment $comment, LifecycleEventArgs $event)
    //{
        //$em = $event->getEntityManager();
        //var_dump('postPersistHandler Comment');
        //die();
    //}
}
