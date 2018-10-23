<?php

namespace App\Form;

use App\Entity\Step;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', null, array(
                'label' => 'N° ordre',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
            ->add('name', null, array(
                'label' => 'Intitulé',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
            ->add('stepDefault', null, array(
                'label' => 'Étape par défaut ?',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Step::class,
        ]);
    }
}
