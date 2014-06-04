<?php
namespace Blogger\BlogBundle\EventListener;

use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class UserViewListener
{
    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        $data = $event->getControllerResult();
        $request = $event->getRequest();
        $data['user'] = $request->getUser();
        $event->setControllerResult($data);
        //var_dump($data);
        return;
    }
}
?>
