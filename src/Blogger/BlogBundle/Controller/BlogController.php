<?php
namespace Blogger\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Blogger\BlogBundle\Entity\Blog;

/**
 * Blog controller.
 **/
class BlogController extends Controller
{
    public function showAction($id)
    {
        $translated = $this->get('translator')->trans('Symfony2 is great');

        $logger = $this->get('monolog.logger.applog');
        $logger->info('log test!-----------------------', array());
        $logger->notice('log test!-----------------------', array());
        $logger->warning('log test!-----------------------', array());
        //$logger->error('log test!-----------------------', array());
        //$user = print_r($this->getUser(), true);
        //$logger->notice("user: $user", array());
        $logger->notice("trans: $translated", array());
        $local_names = print_r($this->get('request'), true);
        $logger->notice("locale: $local_names", array());

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to findBlog post.');
        }
        //$comments = $em->getRepository('BloggerBlogBundle:Comment')->getCommentsForBlog($blog->getId());
        $comments = $blog->getComments();
        //$comments = [];
        return $this->render('BloggerBlogBundle:Blog:show.html.twig',
                             array('blog'=> $blog, 'comments'=> $comments));
    }
}
?>
