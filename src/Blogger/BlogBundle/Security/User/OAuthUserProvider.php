<?php

namespace Blogger\BlogBundle\Security\User;

use Blogger\BlogBundle\Entity\User;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\NoResultException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\EntityUserProvider;

class OAuthUserProvider extends EntityUserProvider
{

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

    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        // 第三方应用的名称
        $resourceOwnerName = $response->getResourceOwner()->getName();

        var_dump($resourceOwnerName, $response->getUsername());

        // 第三方的用户名
        $username = $response->getUsername();
        $user = $this->em->getRepository('BloggerBlogBundle:User')->findOneBy(array('username' => $username));
        //$user = $this->em->getRepository('BloggerBlogBundle:User')->findOneById(1);

        if (null === $user) {
            throw new UsernameNotFoundException(sprintf("User '%s' not found.", $username));
        }

        return $user;
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
                sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        //var_dump($user);
        return $this->loadUserByUsername($user->getId());
    }

    public function supportsClass($class)
    {
        return $class === 'Blogger\BlogBundle\Security\User\WebserviceUser';
    }
}
?>
