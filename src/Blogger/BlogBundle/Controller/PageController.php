<?php

namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;

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
}
