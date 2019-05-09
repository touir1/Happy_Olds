<?php

namespace HappyOldsMainBundle\Form;

use HappyOldsMainBundle\Utils\JobTypes;
use HappyOldsMainBundle\Utils\RoleTypes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
            ->add('prenom')
            ->add('date_naissance', DateType::class, array(
                'widget' => 'single_text',

                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,

                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
            ))
            ->add('job',ChoiceType::class, array(
                'label' => 'Travail',
                'choices' => array(
                    'Medecin' => JobTypes::Medecin,
                    'Ingénieur' => JobTypes::Ingenieur,
                    'Autre' => JobTypes::Autre
                ),
                'required' => true,
                'multiple' => false,
                'data' => 'autre',
            ))
            ->add('ville',ChoiceType::class, array(
                'label' => 'Ville',
                'choices' => array(
                    'Tunis' => 'Tunis',
                    'Ariana' => 'Ariana',
                    'Ben Arous' => 'Ben Arous',
                    'Béja' => 'Béja',
                    'Bizerte' => 'Bizerte',
                    'Gabes' => 'Gabes',
                    'Jandouba' => 'Jandouba',
                    'Gafsa' => 'Gafsa',
                    'Kairouan' => 'Kairouan',
                    'kasserine' => 'kasserine',
                    'Kebili' => 'Kebili',
                    'La manouba' => 'La manouba',
                    'le kef' => 'le kef',
                    'Mahdia' => 'Mahdia',
                    'Médenine' => 'Médenine',
                    'Monastir' => 'Monastir',
                    'Nabeul' => 'Nabeul',
                    'Sfax' => 'Sfax',
                    'Sidi Bouzid' => 'Sidi Bouzid',
                    'Siliana' => 'Siliana',
                    'Sousse' => 'Sousse',
                    'Tataouine' => 'Tataouine',
                    'Tozeur' => 'Tozeur',
                    'Zaghouan' => 'Zaghouan',
                ),
                'required' => true,
                'multiple' => false,
                'data' => 'Tunis',
            ))
            ->add('email', EmailType::class, array('label' => 'form.email', 'translation_domain' => 'FOSUserBundle'))
            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))

            ->add('role', ChoiceType::class, array(
                'label' => 'Type',
                'choices' => array(
                    'Jeune' => RoleTypes::Jeune,
                    'Agé' => RoleTypes::Age
                ),
                'required' => true,
                'multiple' => false,
                'data' => RoleTypes::Jeune,
             ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HappyOldsMainBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'happyoldsmainbundle_user';
    }


}
