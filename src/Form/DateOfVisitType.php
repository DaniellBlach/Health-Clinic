<?php

namespace App\Form;

use App\Entity\Doctor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DateOfVisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Doctor', EntityType::class, [
                'label' => 'Lekarz',
                'class' => Doctor::class,
                'choice_label' => function ($value) {
                    return $value;
                },
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Data',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datePicker bg-white'
                ],
            ])
            ->add('startTime', TimeType::class, [
                'label' => 'Godzina rozpoczęcia',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control timePicker bg-white'
                ],
            ])
            ->add('endTime', TimeType::class, [
                'label' => 'Godzina Zakończenia',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control timePicker bg-white'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
