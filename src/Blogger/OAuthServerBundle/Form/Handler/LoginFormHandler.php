<?php

namespace Blogger\OAuthServerBundle\Form\Handler;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * LoginFormHandler
 */
class LoginFormHandler
{
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(Request $request, FormInterface $form)
    {
        if ('POST' === $request->getMethod()) {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $userProvider = $this->container->get('blogger_oauth_server.user_provider');
                $providerKey = $this->container->getParameter('blogger_oauth_server.provider_key');
                $token = new UsernamePasswordToken($data['username'], $data['password'], $userProvider);

                $authenticator = $this->container->get('blogger_oauth_server.authenticator');
                try {
                    $token = $authenticator->authenticateToken($token, $userProvider, $providerKey);
                } catch (\Exception $e) {
                    return false;
                }

                return $token;
            }
        }

        return false;
    }

}
