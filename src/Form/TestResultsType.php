<?php

namespace App\Form;

use App\Entity\TestResults;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestResultsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Dzień wykonania badania',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datePicker bg-white'
                ],
            ])
            ->add('time', TimeType::class, [
                'label' => 'Godzina wykonania badania',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control timePicker bg-white'
                ],
            ])
            ->add('hematocrit', null, [
                'label' => 'Hematokryt',
                'attr' => ['class' => 'form-control']
            ])
            ->add('hemoglobin', null, [
                'label' => 'Hemoglobina',
                'attr' => ['class' => 'form-control']
            ])
            ->add('leukocytes', null, [
                'label' => 'Lekocyty',
                'attr' => ['class' => 'form-control']
            ])
            ->add('lymphocytes', null, [
                'label' => 'Limfocyty',
                'attr' => ['class' => 'form-control']
            ])
            ->add('erythrocytes', null, [
                'label' => 'Erocyty',
                'attr' => ['class' => 'form-control']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TestResults::class,
        ]);
    }
}
