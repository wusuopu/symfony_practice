<?php
namespace Blogger\BlogBundle\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimpleFormAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\Cookie;

class TimeAuthenticator implements SimpleFormAuthenticatorInterface
{
    private $encoderFactory;

    /**
     * @var KernelInterface
     *
     * Kernel
     */
    protected $kernel;

    public function __construct(EncoderFactoryInterface $encoderFactory, KernelInterface $kernel)
    {
        $this->encoderFactory = $encoderFactory;
        $this->kernel = $kernel;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        try {
            $user = $userProvider->loadUserByUsername($token->getUsername());
        } catch (UsernameNotFoundException $e) {
            throw new AuthenticationException('Invalid username or password');
        }

        $encoder = $this->encoderFactory->getEncoder($user);
        $passwordValid = $encoder->isPasswordValid(
            $user->getPassword(),
            $token->getCredentials(),
            $user->getSalt()
        );
        //$passwordValid = !strcmp($token->getCredentials(), '123');
        //var_dump($user, !empty($user));
        //$passwordValid = !empty($user);

        if ($passwordValid) {
            //$currentHour = date('G');
            //if ($currentHour < 14 || $currentHour > 16) {
                //throw new AuthenticationException(
                    //'You can only log in between 2 and 4!',
                    //100
                //);
            //}

            $container = $this->kernel->getContainer();

            if ($container->hasParameter('deepinid_sso.lifetime')) {
                $lifetime = $container->getParameter('deepinid_sso.lifetime') + time();
            } else {
                $lifetime = 0;
            }

            if ($container->hasParameter('deepinid_sso.path')) {
                $path = $container->getParameter('deepinid_sso.path');
            } else {
                $path = "/";
            }

            if ($container->hasParameter('deepinid_sso.domain')) {
                $domain = $container->getParameter('deepinid_sso.domain');
            } else {
                $domain = null;
            }

            if ($container->hasParameter('deepinid_sso.secure')) {
                $secure = $container->getParameter('deepinid_sso.secure');
            } else {
                $secure = false;
            }

            if ($container->hasParameter('deepinid_sso.httponly')) {
                $httponly = $container->getParameter('deepinid_sso.httponly');
            } else {
                $httponly = true;
            }
            $request = $container->get('request');
            $request->attributes->set(
                $container->getParameter('deepinid_sso.attr_cookie_name'),
                new Cookie(
                    $container->getParameter('deepinid_sso.name'),      // cookie name
                    "test-content",   // cookie value
                    $lifetime,                                          // expire
                    $path,
                    $domain,
                    $secure,
                    $httponly
                )
            );
            return new UsernamePasswordToken(
                $user,
                $user->getPassword(),
                $providerKey,
                $user->getRoles()
            );
        }

        throw new AuthenticationException('Invalid username or password');
    }

    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof UsernamePasswordToken
            && $token->getProviderKey() === $providerKey;
    }

    public function createToken(Request $request, $username, $password, $providerKey)
    {
        return new UsernamePasswordToken($username, $password, $providerKey);
    }
}
?>
