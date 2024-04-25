<?php

namespace App\Form;

use App\Entity\Livre;
use App\Entity\Prets;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PretsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateFin', null, [
                'widget' => 'single_text',
            ])
            ->add('dateDebut', null, [
                'widget' => 'single_text',
            ])
            ->add('dateRendu', null, [
                'widget' => 'single_text',
            ])
            ->add('extension')
            ->add('livre', EntityType::class, [
                'class' => Livre::class,
                'choice_label' => 'id',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Prets::class,
        ]);
    }
}
