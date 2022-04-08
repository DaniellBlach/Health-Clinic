<?php

namespace App\Form;

use App\Entity\MedicalVisit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicalVisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('symptoms', null, [
                'label' => 'Symptomy',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('diagnosis', null, [
                'label' => 'Diagnoza',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('recommendations', null, [
                'label' => 'Zalecenia',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('additionalInformation', null, [
                'label' => 'Informacje dodatkowe',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MedicalVisit::class,
        ]);
    }
}
