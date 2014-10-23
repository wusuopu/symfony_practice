<?php

namespace Blogger\OAuthServerBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Grant the first user of db as a admin user.
 */
class ClientCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('oauth:client')
            ->setDescription('add a oauth client.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $clientManager = $this->getContainer()->get('fos_oauth_server.client_manager.default');
        $client = $clientManager->createClient();
        $client->setRedirectUris(array('http://127.0.0.1:8000'));
        $client->setAllowedGrantTypes(array('token', 'authorization_code', 'password'));
        $clientManager->updateClient($client);

        $router = $this->getContainer()->get('router');
        $authUrl = $router->generate('fos_oauth_server_authorize', array(
            'client_id' => $client->getPublicId(),
            'redirect_uri' => 'http://127.0.0.1:8000',
            'response_type' => 'code',
        ), true);

        var_dump($authUrl);
    }
}
