<?php

namespace Blogger\OAuthServerBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

/**
 * LoginFormType
 */
class LoginFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array(
                'constraints' => array(
                    new NotBlank(),
                ),
            ))
            ->add('password', 'password', array(
                'constraints' => array(
                    new Length(array('min' => 3, 'max' => 32)),
                    new NotBlank(),
                ),
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_oauth_server_login';
    }
}
