<?php

namespace Blogger\OAuthServerBundle\Controller;

use FOS\OAuthServerBundle\Controller\AuthorizeController as BaseAuthorizeController;
use FOS\OAuthServerBundle\Event\OAuthEvent;
use FOS\OAuthServerBundle\Form\Handler\AuthorizeFormHandler;
use OAuth2\OAuth2;
use OAuth2\OAuth2ServerException;
use OAuth2\OAuth2RedirectException;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AuthorizeController extends BaseAuthorizeController
{
    /**
     * {@inheritDoc}
     */
    public function authorizeAction(Request $request)
    {
        try {
            $this->getClient();
        } catch (\Exception $e) {
            // 显示出错页面
            return $this->container->get('templating')->renderResponse(
                'BloggerOAuthServerBundle:Authorize:error.html.twig',
                array('error' => $e->getMessage())
            );
        }

        $container = $this->container;
        $token = $container->get('security.context')->getToken();
        $user = empty($token) ? null : $token->getUser();

        if (!($user instanceof UserInterface)) {
            // 显示登陆框
            $formType = $this->container->getParameter('blogger_oauth_server.login.form.type');
            $loginForm = $container->get('form.factory')->create(new $formType());
            $loginFormHandler = $container->get('blogger_oauth_server.login.form.handler');

            if (!(($token = $loginFormHandler->process($request, $loginForm)) instanceof TokenInterface)) {
                return $container->get('templating')->renderResponse(
                    'BloggerOAuthServerBundle:Authorize:login.html.twig',
                    array('form' => $loginForm->createView())
                );
            }
            $container->get('security.context')->setToken($token);
            $user = $token->getUser();
        }

        if (true === $this->container->get('session')->get('_fos_oauth_server.ensure_logout')) {
            $this->container->get('session')->invalidate(600);
            $this->container->get('session')->set('_fos_oauth_server.ensure_logout', true);
        }

        $form = $this->container->get('fos_oauth_server.authorize.form');
        $formHandler = $this->container->get('fos_oauth_server.authorize.form.handler');

        $event = $this->container->get('event_dispatcher')->dispatch(
            OAuthEvent::PRE_AUTHORIZATION_PROCESS,
            new OAuthEvent($user, $this->getClient())
        );

        if ($event->isAuthorizedClient()) {
            $scope = $this->container->get('request')->get('scope', null);

            return $this->container
                ->get('fos_oauth_server.server')
                ->finishClientAuthorization(true, $user, $request, $scope);
        }

        if (true === $formHandler->process()) {
            return $this->processSuccess($user, $formHandler, $request);
        }

        return $this->container->get('templating')->renderResponse(
            'BloggerOAuthServerBundle:Authorize:authorize.html.' . $this->container->getParameter('fos_oauth_server.template.engine'),
            array(
                'form'      => $form->createView(),
                'client'    => $this->getClient(),
            )
        );
    }
}
