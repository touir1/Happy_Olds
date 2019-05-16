<?php

namespace ChatRoomBundle\Form;

use ChatRoomBundle\Utils\GroupeTypes;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description', TextareaType::class)
            ->add('type', ChoiceType::class, array(
                'label' => 'Type',
                'choices' => GroupeTypes::getNamedArray(),
                'required' => true,
                'multiple' => false,
                'data' => GroupeTypes::getDefault(),
            ))
            ->add('sujet',EntityType::class, [
                'class' => 'ChatRoomBundle:GroupeSujet',
                'choice_label' => 'label',
                'multiple' => false,
            ])
            ->add('valider', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ChatRoomBundle\Entity\Groupe'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'chatroombundle_groupe';
    }


}
