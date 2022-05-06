<?php

namespace App\Form;

use App\Entity\PublicationSignaler;
use App\Entity\Utilisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationSignalerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type',EntityType::class,['class'=>PublicationSignaler::class,'choice_label'=>'Type'])
            ->add('date')
            ->add('idUtilisateur',EntityType::class,['class'=>Utilisateurs::class,'choice_label'=>'idUtilisateur'])
            ->add('idPublication',EntityType::class,['class'=>PublicationSignaler::class,'choice_label'=>'idPublication'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PublicationSignaler::class,
        ]);
    }
}
