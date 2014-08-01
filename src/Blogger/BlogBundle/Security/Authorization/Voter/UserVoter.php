<?php
namespace Blogger\BlogBundle\Security\Authorization\Voter;

use Symfony\Component\Security\Core\Exception\InvalidArgumentException;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserVoter implements VoterInterface
{
    const VIEW = 'view';
    const EDIT = 'edit';

    public function supportsAttribute($attribute)
    {
        return in_array($attribute, [self::VIEW, self::EDIT]);
    }
    
    public function supportsClass($class)
    {
        return true;
    }

    public function vote(TokenInterface $token, $post, array $attributes)
    {
        //if (!$this->supportsClass(get_class($post))) {
            //return VoterInterface::ACCESS_ABSTAIN;
        //}

        if (1 !== count($attributes)) {
            throw new InvalidArgumentException('Only one attribute is allowrd for VIEW or EDIT');
        }

        //$attribute = $attributes[0];
        //$user = $token->getUser();

        //if (!$user instanceof UserInterface) {
            //return VoterInterface::ACCESS_DENIED;
        //}

        return VoterInterface::ACCESS_GRANTED;

        switch ($attribute) {
            case 'view':
                return VoterInterface::ACCESS_GRANTED;
                break;
            case 'edit':
                return VoterInterface::ACCESS_GRANTED;
                break;
            
        }
    }
}

?>
