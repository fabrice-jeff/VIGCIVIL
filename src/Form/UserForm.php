<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule')
            ->add('password')
            ->add('nom')
            ->add('prenoms')
            ->add('email')
            ->add('fonction', ChoiceType::class, [
                'choices' => [
                    'Agent de ministère' => 'agent',
                    'Agent du consulat' => 'particulier',
                ],
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Choisissez une option',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
