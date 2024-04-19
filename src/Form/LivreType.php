<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Livre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom')
            ->add('Auteur')
            ->add('anneePublication')
            ->add('Resume')
            ->add('image')
            ->add('Disponibilite')
            ->add('note')
            ->add('dateRendu')
            ->add('etat', EntityType::class, [
                'class' => Etat::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
