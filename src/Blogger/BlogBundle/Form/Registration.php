<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Validator\Constraints as Assert;
use Blogger\BlogBundle\Entity\User;
use Blogger\BlogBundle\Entity\Profile;

class Registration
{
    /**
     * @Assert\Type(type="Blogger\BlogBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;

    /**
     * @Assert\Type(type="Blogger\BlogBundle\Entity\Profile")
     * @Assert\Valid()
     */
    protected $profile;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setProfile(Profile $profile)
    {
        $this->profile = $profile;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }
}
?>
