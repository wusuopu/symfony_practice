<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email')
                ->add('username')
                ->add('password', 'repeated', array(
                    'first_name' => 'password',
                    'second_name' => 'confirm',
                    'type' => 'password',
                ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\User'
        ));
    }

    public function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('username', new NotBlank(array('message'=> 'You must enter your name')));
        $metadata->addPropertyConstraint('email', new NotBlank(array('message'=> 'You must enter a comment')));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_user';
    }
}
