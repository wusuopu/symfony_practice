<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        //$req = var_export($request, true);
        //$ses = print_r($session, true);
        $logger = $this->get('monolog.logger.applog');
        //$logger->info('request:' . $req, array());
        //$logger->info('session:' . $ses, array());
        foreach ($request as $k => $v) {
            $logger->info("$k => " . print_r($v, true), []);
        }
        foreach ($session as $k => $v) {
            $logger->info("$k => $v", []);
        }

        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
            $session->remove(SecurityContext::AUTHENTICATION_ERROR);
        }

        return $this->render('BloggerBlogBundle:Security:login.html.twig',
                             array('last_username' => $session->get(SecurityContext::LAST_USERNAME), 'error' => $error));
    }

    public function dumpStringAction()
    {
        return $this->render('BloggerBlogBundle:Security:dumpString.html.twig', []);
    }
}

?>
