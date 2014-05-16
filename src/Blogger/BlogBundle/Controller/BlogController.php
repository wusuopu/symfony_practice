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
        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to findBlog post.');
        }
        $comments = $em->getRepository('BloggerBlogBundle:Comment')->getCommentsForBlog($blog->getId());
        return $this->render('BloggerBlogBundle:Blog:show.html.twig',
                             array('blog'=> $blog, 'comments'=> $comments));
    }
}
?>
