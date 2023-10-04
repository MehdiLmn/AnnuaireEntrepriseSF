<?php

namespace App\Form;

use App\Entity\ContractType;
use App\Entity\Sector;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'admin' => 'ROLE_ADMIN',
                    'user' => 'ROLE_USER'
                ]
            ])
            ->add('password', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'required' => false,
            ])
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add('face_picture', TextType::class)
            ->add('realise_date', DateTimeType::class)
            ->add('contractType', ChoiceType::class, [
                'choices' => [
                    'Contrat à durée indéterminée' => 'CDI',
                    'Contrat à durée déterminée' => 'CDD',
                    'Contrat intérimaire' => 'Interim',
                ],
                'choice_value' => 'name',
                'choice_label' => function (?ContractType $contractType): string {
                    return $contractType ? strtoupper($contractType->getName()) : 'Type de contrat';
                },
            ])
            ->add('sector', ChoiceType::class, [
                'choices' => [
                    'Direction' => 'Direction',
                    'RH' => 'RH',
                    'Informatique' => 'Informatique',
                ],
                'choice_value' => 'name',
                'choice_label' => function (?Sector $sector): string {
                    return $sector ? strtoupper($sector->getName()) : 'Secteur';
                },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
