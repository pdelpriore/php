<?php

namespace App\Form;

use App\Entity\ActivityGroup;

use App\Repository\ActivityRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActivityGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Intitulé',
                'attr' => [
                    'class' => 'input-sm col-md-3',
                ]
            ))
            ->add('rate', MoneyType::class, array(
                'label' => 'Part /projet',
                'attr' => [
                    'class' => 'input-sm col-md-1 rightAlign',
                ],
                'currency' => '4'
            ))
            ->add('serial_number', null, array(
                'label' => "N° d'ordre",
                'attr' => [
                    'required' => true,
                    'class' => 'input-sm col-md-1 rightAlign',
                ]
            ))
            ->add('automatic', null, array(
                'label' => "Trait. auto",
                'attr' => [
                    'class' => 'input-sm col-md-1',
                ]
            ))
            ->add('referent', null, array(
                'label' => "Référent ?",
                'attr' => [
                    'class' => 'input-sm col-md-1',
                ]
            ))
            ->add('activities', CollectionType::class, array(
                'entry_type' => ActivityType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ActivityGroup::class,
        ]);
    }
}
