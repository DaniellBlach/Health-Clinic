<?php

namespace App\Form;

use App\Entity\Doctor;
use App\Entity\Patient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('doctorOfFirstContact', EntityType::class, [
                'label' => 'Lekarz pierwszego kontaktu',
                'class' => Doctor::class,
                'choice_label' => function ($value) {
                    return $value;
                },
                'multiple' => false,
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('name', null, [
                'label' => 'Imię',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('surname', null, [
                'label' => 'Nazwisko',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('pesel', null, [
                'label' => 'Pesel',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 11,
                        'minMessage' => 'Podaj poprawny numer pesel',
                        'max' => 11,
                    ]),
                ],
            ])
            ->add('dateOfBirth', DateType::class, [
                'label' => 'Data urodzin',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datePicker bg-white'
                ],
            ])
            ->add('sex', ChoiceType::class, [
                'label' => 'Płeć',
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'Mężczyzna' => 'mężczyzna',
                    'Kobieta' => 'kobieta',
                    'Inne' => 'inne'
                ]
            ])
            ->add('phoneNumber', null, [
                'label' => 'Numer telefonu',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 9,
                        'minMessage' => 'Podaj poprawny numer telefonu',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
