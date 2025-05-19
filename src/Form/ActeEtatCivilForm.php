<?php

namespace App\Form;

use App\Entity\ActeEtatCivil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeEtatCivilForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroActe')
            ->add('prenoms')
            ->add('dateNaissance')
            ->add('lieuNaissance')
            ->add('nomPere')
            ->add('nomMere')
            ->add('typeActe')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActeEtatCivil::class,
        ]);
    }
}
