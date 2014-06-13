<?php

namespace Blogger\BlogBundle\Annotation\Driver;

use Blogger\BlogBundle\Annotations;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;

class AnnotationDriver
{

    private $reader;

    public function __construct($reader)
    {
        $this->reader = $reader;
    }
    public function onKernelController(FilterControllerEvent $event)
    {

        if (!is_array($controller = $event->getController())) {
            return;
        }

        $object = new \ReflectionObject($controller[0]);
        $method = $object->getMethod($controller[1]);

        var_dump($controller);
        //var_dump($method);
        foreach ($this->reader->getMethodAnnotations($method) as $configuration) {
            var_dump($configuration);
            if(isset($configuration->perm)){
                //$perm = new Permission($controller[0]->get('doctrine.odm.mongodb.document_manager'));
                //$userName = $controller[0]->get('security.context')->getToken()->getUser()->getUserName();
                //if(!$perm->isAccess($userName,$configuration->perm)){
                           //throw new AccessDeniedHttpException();

                //}
                //var_dump("in AnnotationDriver xxxxxx");
                //var_dump($configuration);
                //var_dump($controller[0]->get('security.context')->getToken()->getUser());
                if ($configuration->perm != "ok") {
                    //throw new AccessDeniedHttpException();
                    //var_dump($configuration->perm);
                    //$event->setResponse();
                    $event->setController(function() {
                        return new RedirectResponse('/', 302);
                    });
                }
             }
         }
    }
}
