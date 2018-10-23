<?php

namespace App\Form;

use App\Entity\Detail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DetailShowType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('activityGroup', null, array(
                'label' => false,
                'choice_label' => 'name',
                'attr' => [
                    'style' => 'display: none; ',
                ],
            ))
            ->add('rd_number', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .3em; text-align: right;',
                ],
            ))
            ->add('description', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-12',
                    'style' => 'margin-bottom: .3em;',
                    'autofocus' => true,
                ],
            ))
            ->add('profil', null, array(
                'label' => false,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .3em;',
                ],
            ))
            ->add('calculated_days',null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .3em; text-align: right;',
                    'readonly' => 'readonly',
                ],
            ))
            ->add('price', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1 price',
                    'style' => 'margin-bottom: .3em; text-align: right;',
                    'readonly' => 'readonly',
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Detail::class,
        ]);
    }
}
