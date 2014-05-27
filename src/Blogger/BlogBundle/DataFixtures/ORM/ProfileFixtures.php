<?php
namespace Blogger\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Blogger\BlogBundle\Entity\Profile;

class ProfileFixtures extends AbstractFixture implements OrderedFixtureInterface
{
    
    function load(ObjectManager $manager)
    {
        $user = $this->getReference('user-1');
        $profile = new Profile();
        $profile->setUser($user);
        $user->setProfile($profile);

        $manager->persist($user);
        $manager->persist($profile);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
?>
