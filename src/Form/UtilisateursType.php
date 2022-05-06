<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateursType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('datenaissance')
            ->add('genre')
            ->add('numTel')
            ->add('email')
            ->add('avatar')
            ->add('mdp')
            ->add('typeUser')
            ->add('passwordrequestedat')
            ->add('token')
            ->add('activated')
            ->add('nbsignal')
            ->add('evaluation')
            ->add('sponsor')
            ->add('desactivated')
            ->add('creationDate')
            ->add('idCollab')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
