<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class PasswdType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', 'text', array('label' => "用户名"))
                ->add('password', 'password', array('label' => "旧密码"))
                //->add('new_password', 'repeated', array(
                    //'first_name' => 'password',
                    //'second_name' => 'confirm',
                    //'type' => 'password',
                //))
                ->add("Change", "submit");
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

    //public function loadValidatorMetadata(ClassMetadata $metadata)
    //{
        ////$metadata->addPropertyConstraint('username', new NotBlank(array('message'=> 'You must enter your name')));
        //$metadata->addPropertyConstraint('password', new SecurityAssert\UserPassword(array(
            //'message' => 'Wrong value for your current password',
        //)));
    //}

    /**
     * @return string
     */
    public function getName()
    {
        return 'blogger_blogbundle_password';
    }
}
