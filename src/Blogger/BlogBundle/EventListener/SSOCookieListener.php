<?php
namespace Blogger\BlogBundle\EventListener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelInterface;

class SSOCookieListener
{
    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function onKernelRespone(FilterResponseEvent $event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $container = $this->kernel->getContainer();
        if ($request->attributes->has($container->getParameter('deepinid_sso.attr_cookie_name'))) {
            $response->headers->setCookie($request->attributes->get($container->getParameter('deepinid_sso.attr_cookie_name')));
        }
    }
}
?>
