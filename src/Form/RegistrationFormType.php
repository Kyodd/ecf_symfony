<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Email',
            ]  )

            ->add('nom', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nom',
            ]  )

            ->add('prenom', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prénom',
            ]  )

            ->add('birthdate', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Date de naissance',
            ]  )

            ->add('adresse', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Adresse',
            ]  )

            ->add('codepostal', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Code postal',
            ]  )

            ->add('ville', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Ville',
            ]  )

            ->add('phonenumber', null, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Numéro de téléphone',
            ]  )



            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => 'Accepter les conditions générales',
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent être identiques.',
                'options' => [
                    'attr' => [
                        'class' => 'form-control',
                    ]
                ],
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe.'
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères.',
                            'max' => 48,
                        ]),
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ],
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
