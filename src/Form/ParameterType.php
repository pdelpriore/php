<?php

namespace App\Form;

use App\Entity\Parameter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('paramKey', null, array(
                'label' => 'Clé',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em;',
//                    'readonly' => 'readonly',
                ],
            ))
            ->add('paramValue', null, array(
                'label' => 'Valeur',
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
            'data_class' => Parameter::class,
        ]);
    }
}
