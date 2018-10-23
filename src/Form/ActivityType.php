<?php

namespace App\Form;

use App\Entity\Activity;
use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('serialNumber', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('name', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-3',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('profil', null, array(
                'label' => false,
                'choice_label' => 'name',
                'placeholder' => '',
                'attr' => [
                    'class' => 'input-sm col-md-3',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
            ->add('rate', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .4em;',
                ],
                'scale' => 2,
            ))
            ->add('minHours', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activity::class,
        ]);
    }
}
