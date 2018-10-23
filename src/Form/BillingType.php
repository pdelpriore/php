<?php

namespace App\Form;

use App\Entity\Billing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Intitulé',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
            ->add('alias', null, array(
                'label' => 'Alias',
                'attr' => [
                    'class' => 'form-control input-sm',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
            ->add('billDefault', null, array(
                'label' => 'Billing par défaut ?',
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
            'data_class' => Billing::class,
        ]);
    }
}
