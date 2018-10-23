<?php

namespace App\Form;

use App\Entity\CertaintyLevel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CertaintyLevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rate',  null, array(
                'label' => 'Pondération',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em; ; text_align: right;',
                ],
//                'number_format' => '(2, ",", ".")',
            ))
            ->add('name', null, array(
                'label' => 'Niveau',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em',
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => CertaintyLevel::class,
        ]);
    }
}
