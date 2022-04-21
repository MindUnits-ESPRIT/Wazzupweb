<?php

namespace App\Form;

use App\Entity\Publication;
use App\Entity\Utilisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description',TextareaType::class)
            ->add('fichier',HiddenType::class,[
                'empty_data' => 'NULL',
            ])
            ->add('visibilite',ChoiceType::class,['choices'  => [
                'True' => 'True',
                'False' => 'False',
                'Hidden' => 'Hidden',
            ]])
//            ->add('visibilite')
            ->add('priority',HiddenType::class)
//            ->add('datePublication')
            ->add('idUtilisateur',EntityType::class,['class'=>Utilisateurs::class,'choice_label'=>'idUtilisateur'])
//            ->add('Submit',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
        ]);
    }
}
