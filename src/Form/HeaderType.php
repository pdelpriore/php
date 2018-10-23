<?php

namespace App\Form;

use App\Entity\Header;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class HeaderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', null, array(
                'label' => 'Objet',
                'attr' => [
                    'class' => 'input-sm col-md-10',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('cyllenePerson', null, array(
                'choice_label' => 'name',
                'label' => 'Chiffreur',
                'placeholder' => '',
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .4em;',
                ],
            ))
            ->add('application', null, array(
                'choice_label' => 'name',
                'label' => 'Application',
                'placeholder' => '',
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('inChargePerson', null, array(
                'choice_label' => 'fullName',
                'label' => 'Demandeur',
                'placeholder' => '',
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('application_version', null, array(
                'label' => 'Version Appli',
                'empty_data' => '',
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('billing', null, array(
                'choice_label' => 'name',
                'label' => 'Facturation',
                'attr' => [
                    'class' => 'input-sm col-md-2',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('billNumber', null, array(
                'label' => 'N° de Facture',
                'attr' => [
                    'class' => 'input-sm col-md-1',
                    'style' => 'margin-bottom: .4em;',
                ]
            ))
            ->add('details', CollectionType::class, array(
                'entry_type' => DetailType::class,
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
            'data_class' => Header::class,
        ]);
    }
}
