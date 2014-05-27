<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user', new UserType())
                ->add('profile', new ProfileType())
                ->add('terms', 'checkbox', array('property_path' => 'termsAccepted'))
                ->add('Register', 'submit');
    }
    

    /**
     * @return string
     */
    public function getName()
    {
        return 'register';
    }
}
