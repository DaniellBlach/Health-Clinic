<?php

namespace App\Form;

use App\Entity\Doctor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class DoctorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('specialization', null, [
                'label' => 'Specializacja',
                'attr' => ['class' => 'form-control'],
            ])
            ->add('licenseNumber', null, [
                'label' => 'Numer prawa wykonywania zawodu',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Length([
                        'min' => 7,
                        'minMessage' => 'Podaj poprawny numer licencji',
                        'max' => 7,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Doctor::class,
        ]);
    }
}
