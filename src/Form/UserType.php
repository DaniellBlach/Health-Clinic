<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new Email([
                        'mode'=> 'html5',
                        'message' => 'Podany email nie jest właściwy',
                    ]),
                ],
            ])
            ->add('roles',ChoiceType::class,[
                'label' => 'Rola pracownika',
                'attr' => ['class' => 'form-control'],
                'choices' => [
                    'administrator systemu' => 'ROLE_ADMIN',
                    'pracownik administracyjny' => 'ROLE_EMPLOYEE',
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'label' => 'Hasło',
                'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Wprowadź hasło',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Twoje hasło powinno mieć conajmniej 8 znaków',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                    new Regex([
                        'pattern' => '/[#?!@$%^&*-]+/i',
                        'message' => 'Podaj przynajmniej jeden znak specialny'
                    ]),
                    new Regex([
                        'pattern' => '([a-z])',
                        'message' => 'Podaj przynajmniej jedną małą literę'
                    ]),
                    new Regex([
                        'pattern' => '([A-Z])',
                        'message' => 'Podaj przynajmniej jedną dużą literę'
                    ])
                ],
            ])
            ->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    // transform the array to a string
                    return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                    // transform the string back to an array
                    return [$rolesString];
                }
            ));

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
