<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Blogger\BlogBundle\Form\RegisterType;
use Blogger\BlogBundle\Form\Registration;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Entity\Profile;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Blogger\BlogBundle\Form\PasswdType;

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

    /**
     * @Template()
     **/
    public function passwdChangeAction()
    {
        $request = $this->get('request');

        //$user = $this->getUser();
        $user = new User();
        $form    = $this->createForm(new PasswdType(), $user);
        $form->bind($request);

        $logger = $this->get('monolog.logger.applog');
        $logger->info("passwd form: "  . $form->isValid());
        if ($form->isValid()) {
            $data = $form->getData();
            $logger->info("passwd form: " . $data->getUsername() . " " . $data->getPassword());
            //$em = $this->getDoctrine()->getManager();
            //$em->persist($user);
            //$em->flush();
        }

        return ['form'=> $form->createView()];
    }

    /**
     * @Template()
     **/
    public function test1Action()
    {
        $request = $this->get("request");
        //$session = $request->getSession();
        $session = $this->get('session');

        $logger = $this->get('monolog.logger.applog');
        $logger->info('user_id: '. $session->get('user_id'));

        $sec = $this->get('security.context');
        $token = $sec->getToken();
        $user = $this->getUser();

        if (empty($user)) {
            $providerKey = 'secured_area';
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('BloggerBlogBundle:User')->find(1);
            $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());
            $sec->setToken($token);

            // dispatch the login event
            $event = new InteractiveLoginEvent($request, $token);
            $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);
        }

        $logger = $this->get('monolog.logger.applog');
        return array(
            'user' => $this->getUser(),
            'sec' => $sec,
            'token' => $token,
            'session' => $session,
            'cookies' => $request->cookies,
        );
    }

    /**
     * @Template()
     **/
    public function test2Action()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        $session->set('user_id', 12);

        $sec = $this->get('security.context');
        $token = $sec->getToken();
        $sec->setToken(NULL);       // force logout

        $logger = $this->get('monolog.logger.applog');
        return array(
            //'user' => $this->getUser(),
            'sec' => $sec,
            'token' => $token,
        );
    }
}

?>
