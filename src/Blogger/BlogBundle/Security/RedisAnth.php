<?php

namespace Blogger\BlogBundle\Security;

use Blogger\BlogBundle\Entity\User;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;

class RedisAnth
{

    private $em;
    private $sec;
    private $redis;

    public function __construct($em, $sec, $redis)
    {
        $this->em = $em;
        $this->sec = $sec;
        $this->redis = $redis;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $token = $this->sec->getToken();
        if (empty($token)) {
            $user = null;
        } else {
            $user = $token->getUser();
            if (!$user instanceof User) {
                $user = null;
            }
        }
        //var_dump($token, $user);
        $userId = 0;
        try {
            $userId = $this->redis->get('login');
            $this->redis->set('loginid', 'abc');
        } catch (\Exception $e) {
            var_dump($e);
        }
        if ($userId && empty($user)) {
            $providerKey = 'secured_area';
            $user = $this->em->getRepository('BloggerBlogBundle:User')->find($userId);
            if ($user) {
                $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
                $this->sec->setToken($token);
            }
        }

        if (!$userId && $user) {
            $this->sec->setToken(null);
        }
    }
}
