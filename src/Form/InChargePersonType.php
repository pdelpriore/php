<?php

namespace App\Form;

use App\Entity\InChargePerson;
use Doctrine\DBAL\Types\ArrayType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InChargePersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('lastName', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-2 text-uppercase',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('department', null, array(
                'label' => false,
                'attr' => [
                    'class' => 'input-sm col-md-4',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
/*            ->add('applications', CollectionType::class, array(
                'entry_type' => ApplicationType::class,
                'entry_options' => array(
                    'label' => false,
                    'attr' => [
                    ]),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => InChargePerson::class,
        ]);
    }
}
