<?php

namespace Blogger\BlogBundle\Security\User;

use Blogger\BlogBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class WebserviceUserProvider extends ContainerAware implements UserProviderInterface
{
    private $em;
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function loadUserByUsername($username)
    {
        if (is_int($username)) {
            $user = $this->em->getRepository('BloggerBlogBundle:User')->findOneById($username);
        } else {
            $user = $this->em->getRepository('BloggerBlogBundle:User')->findOneByUsername($username);
        }
        //var_dump($user);

        if (!empty($user)) {
            return $user;
        }

        throw new UsernameNotFoundException(
            sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        var_dump($user);
        return $this->loadUserByUsername($user->getId());
    }

    public function supportsClass($class)
    {
        return $class === 'Blogger\BlogBundle\Security\User\WebserviceUser';
    }
}
?>
