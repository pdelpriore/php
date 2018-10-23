<?php

namespace App\Form;

use App\Entity\Application;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('alias', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-1 text-uppercase',
                    'style' => 'text-transform: uppercase;'
                ]
            ))
            ->add('RD_ref', null, array(
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
            'data_class' => Application::class,
        ]);
    }
}
