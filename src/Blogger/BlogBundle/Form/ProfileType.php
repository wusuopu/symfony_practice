<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfileType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('avatar')
                ->add('birthday', 'date')
                ->add('sex', 'choice', array(
                    "choices" => array('0' => 'Male', '1' => 'Femal'),
                    "required" => true,
                ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Profile'
        ));
    }

    //public function loadValidatorMetadata(ClassMetadata $metadata)
    //{
        //$metadata->addPropertyConstraint('usr', new NotBlank(array('message'=> 'You must enter your name')));
        //$metadata->addPropertyConstraint('comment', new NotBlank(array('message'=> 'You must enter a comment')));
    //}

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_profile';
    }
}

