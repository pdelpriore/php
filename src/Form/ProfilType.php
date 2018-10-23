<?php

namespace App\Form;

use App\Entity\Profil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CurrencyType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, array(
                'label' => 'Intitulé',
                'attr' => [
                    'class' => 'input-sm col-md-4',
                ]
            ))
            ->add('dayly_cost', null, array(
                'label' => 'Taux /jour (€)',
                'attr' => [
                    'class' => 'input-sm col-md-1',
                ],
            ))
            ->add('default_selected', null, array(
                'label' => 'Profil par défaut ?',
                'attr' => [
                    'class' => 'input-sm col-md-1',
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Profil::class,
        ]);
    }
}
