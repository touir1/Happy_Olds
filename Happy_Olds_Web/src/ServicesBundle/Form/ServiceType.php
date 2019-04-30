<?php

namespace ServicesBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ServiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('description',TextareaType::class)->add('date',DateTimeType::class)
            ->add('type',ChoiceType::class, array(
            'label' => 'Type de service',
            'choices' => array(
                'Covoiturage' => 'Covoiturage',
                'Faites vous livrer' => 'Faites vous livrer',
                'Autre' => 'autre'
            ),
            'required' => true,
            'multiple' => false,
            'data' => 'autre',
        ))->add('Publier',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ServicesBundle\Entity\Service'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'servicesbundle_service';
    }


}
