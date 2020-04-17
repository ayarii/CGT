<?php

namespace CompetitionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class CompetitionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre')
            ->add('description',TextareaType::class)
            ->add('typedetalent',ChoiceType::class,array('choices'=>array(
                'Musique'=>'Musique',
                'BeatBox'=>'BeatBox',
                'Comédie'=>'Comédie',
                'Dance'=>'Dance',
            )))
            ->add('datedebut', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('datefin', DateType::class, [
                'widget' => 'single_text',
                // this is actually the default format for single_text
                'format' => 'yyyy-MM-dd',
            ])
            ->add('cout')
            ->add('file')
            ->add('valider',SubmitType::class);

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CompetitionBundle\Entity\Competition'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'competitionbundle_competition';
    }


}
