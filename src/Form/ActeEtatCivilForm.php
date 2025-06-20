<?php

namespace App\Form;

use App\Entity\ActeEtatCivil;
use App\Entity\TypeActe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActeEtatCivilForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numeroActe', TextType::class,[
                'label' => "Numéro de l'acte"
            ])
            ->add('nom')
            ->add('prenoms')
            ->add('dateNaissance', DateType::class, [
                'label' => "Date de naissance",
            ])
            ->add('lieuNaissance')
            ->add('nomPere', TextType::class, [
                'label' => "Nom et prénom du père",
            ])
            ->add('nomMere', TextType::class, [
                'label' => "Nom et prénom de la mère"
            ])
            ->add('typeActe', EntityType::class,[
                    'class'         => TypeActe::class,
                    'choice_label'  => 'libelle',
                    'placeholder'   => 'Sélectionnez un type…',
                    'label'         => 'Type de document',
                    'required'      => true,
                    'multiple'      => false,   
                    'expanded'      => false,
                ]
            )
            ->add('copiePdf', FileType::class, [
                'label' => "Choisissez un fichier",
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ActeEtatCivil::class,
        ]);
    }
}
