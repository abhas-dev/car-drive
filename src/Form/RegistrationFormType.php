<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\User;
use App\Security\EmailVerifier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailVerifier::class, [
                'consrtaints' => [
                    new NotBlank(['message' => 'Please enter an email address']),
                    new Email(['message' => 'Please enter a valid email address'])
                ]])
            ->add('agreeTerms', CheckboxType::class, [
                                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre nom']),
                    new Length(['min' => 2, 'max' => 255, 'minMessage' => 'Votre nom doit contenir au moins 2 caractères'])
                ]
            ])
            ->add('firstname', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre prénom']),
                    new Length(['min' => 2, 'max' => 255, 'minMessage' => 'Votre prénom doit contenir au moins 2 caractères'])
                ]
            ])
            ->add('phone', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer votre numéro de téléphone']),
                    new Length(['min' => 10, 'max' => 10, 'minMessage' => 'Votre numéro de téléphone doit contenir 10 caractères'])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
