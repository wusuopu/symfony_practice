<?php
namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Blog;
use Blogger\BlogBundle\Common\LoggerUtil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Blog controller.
 * @Template()
 **/
class BlogController extends Controller
{
    use LoggerUtil;
    public function showAction($id)
    {
        $translated = $this->get('translator')->trans('Symfony2 is great');

        //$logger = $this->get('monolog.logger.applog');
        //$logger->info('log test!-----------------------', array());
        //$logger->notice('log test!-----------------------', array());
        //$logger->warning('log test!-----------------------', array());
        //$logger->error('log test!-----------------------', array());
        //$user = print_r($this->getUser(), true);
        //$logger->notice("user: $user", array());
        //$logger->notice("trans: $translated", array());

        //$local_names = print_r($this->get('request'), true);
        //$logger->notice("locale: $local_names", array());

        $em = $this->getDoctrine()->getManager();
        $blog = $em->getRepository('BloggerBlogBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to findBlog post.');
        }
        if (false === $this->get('security.context')->isGranted('view', $blog)) {
            $this->PutAppLog("Unauthorised access!");
            throw new AccessDeniedException('Unauthorised access this blog!');
        }
        if (false === $this->get('security.context')->isGranted('edit', $blog)) {
            $this->PutAppLog("Unauthorised access for edit!");
        }

        //$comments = $em->getRepository('BloggerBlogBundle:Comment')->getCommentsForBlog($blog->getId());
        $comments = $blog->getComments();
        //$comments = [];

        $sec = $this->get('security.context');
        $token = $sec->getToken();
        return array('blog'=> $blog, 'comments'=> $comments,
                  'user'=>$this->getUser(),
                  'token'=>$token, 'sec'=>$sec,
        );
    }
}
?>
