<?php

namespace Blogger\OAuthServerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends Controller
{
    public function indexAction()
    {
        $sec = $this->container->get('security.context');
        $token = $sec->getToken();
        var_dump($token->getToken(), $token->getUser());

        return new Response("");
    }
}
