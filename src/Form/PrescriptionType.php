<?php

namespace App\Form;

use App\Entity\Prescription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrescriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('medicine', null, [
                'label' => 'Lek',
                'attr' => ['class' => 'form-control']
            ])
            ->add('quantity', null, [
                'label' => 'Liczba opakowań',
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prescription::class,
        ]);
    }
}
