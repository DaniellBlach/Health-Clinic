<?php

namespace App\Form;

use App\Entity\Referral;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('diagnosis', null, [
                'label' => 'rozpoznanie',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('additionalInformation', null, [
                'label' => 'informacje dodatkowe',
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('typeOfReferral', null, [
                'label' => 'Typ skierowania',
                'attr' => [
                    'class' => 'form-control'
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Referral::class,
        ]);
    }
}
