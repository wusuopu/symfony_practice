<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Blogger\BlogBundle\Entity\Blog;

class PageController extends Controller
{
    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

    public function contactAction()
    {
        $enquiry = new Enquiry();
        $form = $this->createForm(new EnquiryType(), $enquiry);

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') 
        {
          $form->bind($request);

          if ($form->isValid()) {
            // 
            $message = \Swift_Message::newInstance()
              ->setSubject('Contact enquiry from symblog')
              ->setFrom('13554499384@163.com')
              ->setTo('longchangjin@linuxdeepin.com')
              ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
            $this->get('mailer')->send($message);

            $this->get('session')->set('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');
            return $this->redirect($this->generateUrl('blogger_blog_contact'));
          }
        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', ['form'=> $form->createView()]);
    }

    public function indexAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        //$logger = $this->get('monolog.logger.applog');
        //foreach ($request as $k => $v) {
            //$logger->info("$k => " . print_r($v, true), []);
        //}
        //foreach ($session as $k => $v) {
            //$logger->info("$k => $v", []);
        //}

        $em = $this->getDoctrine()->getManager();
        //$blogs = $em->createQueryBuilder()->select('b')->from('BloggerBlogBundle:Blog', 'b')
                   //->addOrderBy('b.created', 'DESC')->setFirstResult(2)->setMaxResults(2)
                   //->getQuery()->getResult();
        $blogs = $em->getRepository('BloggerBlogBundle:Blog')->findAll();
        //$blogs = $em->getRepository('BloggerBlogBundle:Blog')->_em->createQueryBuilder()
                    //->select('b')->from('BloggerBlogBundle:Blog', 'b')->addOrderBy('b.created', 'DESC')
                    //->getQuery()->getResult();

        return $this->render('BloggerBlogBundle:Page:index.html.twig', array('blogs'=> $blogs));
    }

    public function mqTestAction()
    {
        $request = $this->getRequest();

        if ($request->isMethod("POST")) {
            $msg = array('content'  => $request->request->get('content'));
            $this->get('old_sound_rabbit_mq.upload_picture_producer')->publish(serialize($msg));
        }

        return $this->render('BloggerBlogBundle:Page:mq.html.twig', array());
    }

    public function mqTest2Action()
    {
        $request = $this->getRequest();

        if ($request->isMethod("POST")) {
            $msg = array('content'  => $request->request->get('content'));
            $this->get('old_sound_rabbit_mq.broadcast_producer')->publish(serialize($msg));
        }

        return $this->render('BloggerBlogBundle:Page:mq.html.twig', array());
    }
}
