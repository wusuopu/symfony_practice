<?php

// src/Blogger/BlogBundle/Tests/Entity/BlogTest.php

namespace Blogger\BlogBundle\Tests\Entity;

use Blogger\BlogBundle\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BlogTest extends WebTestCase
{
    private $client = null;
    private $em = null;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->client = static::createClient();
        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testInsert()
    {
        $blog = new Blog();
        $blog->setTitle("abcd123<br><b>a</b>\n\r4\n\r56");
        $blog->setAuthor("lcj");
        $blog->setBlog("content");
        $blog->setImage('beach.jpg');
        $blog->setTags('symfony2, php, paradise, symblog');

        $validator = $this->client->getContainer()->get('validator');
        $error = $validator->validate($blog);

        var_dump('getTitle1:', $blog->getTitle());


        $filterService = $this->client->getContainer()->get('dms.filter');
        $filterService->filterEntity($blog);

        var_dump('getTitle2:', $blog->getTitle());

        //var_dump($error);
        //$this->assertEquals(count($error), 0);


        //if (count($error)) {
            //return;
        //}

        $this->em->persist($blog);
        $this->em->flush();

        //var_dump($blog->getTitle());
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->em->close();
    }
}
