<?php

namespace Blogger\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
//use Blogger\TestBundle\Entity\Test;
use Serializable;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="Blogger\BlogBundle\Entity\UserRepository")
 * @UniqueEntity(fields={"username", "email"}, errorPath="email", message="this email has already used.")
 */
class User implements UserInterface, \Serializable
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32)
     */
    private $salt;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="emaili", type="string", length=30, unique=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    /**
     * @ORM\OneToOne(targetEntity="Profile")
     * @ORM\JoinColumn(name="profile_id", referencedColumnName="id")
     **/
    private $profile;


    /**
     * @ORM\OneToOne(targetEntity="Blogger\TestBundle\Entity\Test")
     * @ORM\JoinColumn(name="test_id", referencedColumnName="id")
     **/
    private $test;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     **/
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritdoc
     **/
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @inheritdoc
     **/
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritdoc
     **/
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * @inheritdoc
     **/
    public function eraseCredentials()
    {
    }

    /**
     * @see \Serializable::serialize()
     **/
    public function serialize()
    {
        return serialize(array($this->id, ));
    }

    /**
     * @see \Serializable::unserialize()
     **/
    public function unserialize($serialized)
    {
        list($this->id,) = unserialize($serialized);
    }



    /**
     * Set username
     *
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set profile
     *
     * @param \Blogger\BlogBundle\Entity\Profile $profile
     * @return User
     */
    public function setProfile(\Blogger\BlogBundle\Entity\Profile $profile = null)
    {
        $this->profile = $profile;

        return $this;
    }

    /**
     * Get profile
     *
     * @return \Blogger\BlogBundle\Entity\Profile 
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     * Set test
     *
     * @param \Blogger\TestBundle\Entity\Test $test
     * @return User
     */
    public function setTest(\Blogger\TestBundle\Entity\Test $test = null)
    {
        $this->test = $test;

        return $this;
    }

    /**
     * Get test
     *
     * @return \Blogger\TestBundle\Entity\Test 
     */
    public function getTest()
    {
        return $this->test;
    }
}
