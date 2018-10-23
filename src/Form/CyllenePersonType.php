<?php

namespace App\Form;

use App\Entity\CyllenePerson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CyllenePersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Chiffreur',
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
            'data_class' => CyllenePerson::class,
        ]);
    }
}
