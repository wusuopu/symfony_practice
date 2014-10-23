<?php

namespace Blogger\OAuthServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class BloggerOAuthServerExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $processor = new Processor();
        $config = $processor->processConfiguration(new Configuration(), $configs);

        //$configuration = new Configuration();
        //$config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('blogger_oauth_server.login.form.type', $config['login_form']['type']);
        unset($config['login_form']['type']);

        $container->setAlias('blogger_oauth_server.login.form.handler', $config['login_form']['handler']);
        unset($config['login_form']['handler']);

        $container->setAlias('blogger_oauth_server.user_provider', $config['user_provider']);
        unset($config['user_provider']);

        $container->setAlias('blogger_oauth_server.authenticator', $config['authenticator']);
        unset($config['authenticator']);

        $container->setParameter('blogger_oauth_server.provider_key', $config['provider_key']);
        unset($config['provider_key']);
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'blogger_oauth_server';
    }
}
