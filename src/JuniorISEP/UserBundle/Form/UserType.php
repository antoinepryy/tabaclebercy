<?php

namespace JuniorISEP\UserBundle\Form;

use JuniorISEP\UserBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
              'label' => 'E-mail',
            ))
            // ->add('username', TextType::class)
            ->add('firstname', TextType::class, array(
              'label' => 'Prénom',
            ))
            ->add('lastname', TextType::class, array(
              'label' => 'Nom',
            ))
            ->add('birthdate', DateType::class, array(
              'widget' => 'choice',
              'years' => range(date('Y')-17, date('Y')-100),
              'label' => 'Date de naissance',
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmer mot de passe'),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}

?>
