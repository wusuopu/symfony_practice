<?php
namespace Blogger\BlogBundle\Twig\Extensions;

use Twig_Function_Method;
use Twig_Environment;
class BloggerBlogExtension extends \Twig_Extension
{
    protected $environment;

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->environment = $environment;
    }
    public function getFilters()
    {
        return array(
            'created_ago' => new \Twig_Filter_Method($this, 'createdAgo'),
        );
    }

    public function getFunctions()
    {
        return array(
            'deepin_is_login' => new \Twig_Function_Method($this, 'deepinIsLogin'),
            'deepin_is_granted' => new \Twig_Function_Method($this, 'deepinIsGranted'),
        );
    }

    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \InvalidArgumentException("createdAgo is unable to handle dates in the future");

        $duration = "";
        if ($delta < 60)
        {
            // Seconds
            $time = $delta;
            $duration = $time . " second" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 3600)
        {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "") . " ago";
        }
        else if ($delta <= 86400)
        {
            // Hours
            $time = floor($delta / 3600);
            $duration = $time . " hour" . (($time > 1) ? "s" : "") . " ago";
        }
        else
        {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " day" . (($time > 1) ? "s" : "") . " ago";
        }

        return $duration;
    }

    public function deepinIsLogin()
    {
        $app = $this->environment->getGlobals()['app'];
        $user = $app->getUser();
        // http://symfony.com/doc/current/reference/twig_reference.html
        // app Attributes: app.user, app.request, app.session, app.environment, app.debug, app.security
        //var_dump($app->getSecurity());
        return !empty($user);
    }

    public function deepinIsGranted()
    {
        $security = $this->environment->getGlobals()['app']->getSecurity();
        return $security->isGranted('edit');
    }
    public function getName()
    {
        return 'blogger_blog_extension';
    }   
}
?>
