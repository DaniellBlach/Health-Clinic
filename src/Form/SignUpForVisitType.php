<?php

namespace App\Form;

use App\Entity\DateOfVisit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignUpForVisitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeOfVisit', ChoiceType::class, [
                'label' => false,
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'porada telefoniczna' => 'porada telefoniczna',
                    'wizyta w przychodni' => 'wizyta w przychodni',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DateOfVisit::class,
        ]);
    }
}
