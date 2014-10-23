<?php

namespace Blogger\OAuthServerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('blogger_oauth_server');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $this->addAuthorizeSection($rootNode);

        return $treeBuilder;
    }

    private function addAuthorizeSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('login_form')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('type')->defaultValue('Blogger\OAuthServerBundle\Form\Type\LoginFormType')->cannotBeEmpty()->end()
                        ->scalarNode('handler')->defaultValue('blogger_oauth_server.login.form.handler.default')->cannotBeEmpty()->end()
                    ->end()
                ->end()
                ->scalarNode('authenticator')->cannotBeEmpty()->isRequired()->end()
                ->scalarNode('user_provider')->cannotBeEmpty()->isRequired()->end()
                ->scalarNode('provider_key')->defaultValue('secured_area')->cannotBeEmpty()->end()
            ->end();
    }
}
