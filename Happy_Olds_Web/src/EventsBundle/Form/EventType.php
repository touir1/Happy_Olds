<?php

namespace EventsBundle\Form;

use blackknight467\StarRatingBundle\Form\RatingType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')->add('description')
            ->add('nbrParticipant')
            ->add('dateDebut')
            ->add('dateFin')
            ->add('lieu')
            ->add('file')
            ->add('Valider',SubmitType::class)
            ->add('ville',choiceType::class, array(
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
            ));
           ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'EventsBundle\Entity\Event'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'eventsbundle_event';
    }


}
