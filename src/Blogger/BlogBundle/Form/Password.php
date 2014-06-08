<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Entity\Profile;

class Password
{
    /**
     * @Assert\Type(type="Blogger\BlogBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}
?>

