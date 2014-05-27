<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Blogger\BlogBundle\Form\RegisterType;
use Blogger\BlogBundle\Form\Registration;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Entity\Profile;

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

    public function regAction()
    {
        $request = $this->get('request');
        $session = $request->getSession();

        $reg = new Registration();

        $form = $this->createForm(new RegisterType(), $reg);
        $form->handleRequest($request);

        $logger = $this->get('monolog.logger.applog');
        $ss = print_r($form->isValid(), true);
        $logger->info("form: $ss", []);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $data = $form->getData();

            $user = $data->getUser();
            $profile = $data->getProfile();

            $profile->setUser($user);
            $user->setProfile($profile);
            $user->setSalt(md5(uniqid()));
            $encoder = $this->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($encoder->encodePassword($user->getPassword(), $user->getSalt()));
            $user->setIsActive(true);

            $ss = print_r($user, true);
            $logger->info("user: $ss", []);
            $ss = print_r($profile, true);
            $logger->info("profile: $ss", []);

            $em->persist($user);
            $em->persist($profile);
            $em->flush();

            return $this->redirect('/');
        }

        return $this->render('BloggerBlogBundle:Security:reg.html.twig',
                             array('error' => null, 'form' => $form->createView()));
    }
}

?>
