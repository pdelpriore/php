<?php

namespace App\Form;

use App\Entity\Client;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Nom',
                'attr' => [
                    'class' => 'input-sm',
                    'style' => 'text-transform: uppercase;'
                ]
            ))
            ->add('alias', null, array(
                'label' => 'Alias',
                'error_bubbling' => true,
                'invalid_message' => 'L\'alias saisi est déjà utilisé pour un autre client',
                'attr' => [
                    'class' => 'input-sm',
                    'style' => 'text-transform: uppercase;'
                ]
            ))

            ->add('dayly_cost', null, array(
                'label' => 'Taux journalier',
                'attr' => [
                    'class' => 'input-sm',
                ]
            ))
            ->add('logo', FileType::class, array(
                'label' => 'Logo',
                'required' => false,
                'data_class' => null,
                'attr' => [
                    'class' => 'input-sm',
                ]
            ))
            ->add('in_charge_persons', CollectionType::class, array(
                'entry_type' => InChargePersonType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => true,
            ))
            ->add('applications', CollectionType::class, array(
                'entry_type' => ApplicationType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'error_bubbling' => true,
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
