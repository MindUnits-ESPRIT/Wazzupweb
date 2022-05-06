<?php

namespace App\Form;

use App\Entity\OffrePublicitaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OffrePublicitaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomOffre')
            ->add('contenuOffre')
            ->add('nbrMaxOffre')
            ->add('idUtilisateur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OffrePublicitaire::class,
        ]);
    }
}
