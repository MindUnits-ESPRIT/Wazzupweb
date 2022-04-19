<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Utilisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomEvent')
//            ->add('nomEvent',null,['label_attr' => [
//                'class' => 'Nom de l\'événement',]])

            ->add('nbrParticipants')
            ->add('dateEvent')
            ->add('typeEvent',ChoiceType::class,[
                'choices'  => [
                    '-- Choisir --' => null,
                    'Salle Cinéma'=> 'SalleCinema',
                    'Rencontre'=> 'Rencontre'
                ]
            ])
            ->add('eventVisibilite',ChoiceType::class,[
                'choices'  => [
                    '-- Choisir --' => null,
                    'Salle publique'=> 'Salle_publique',
                    'Salle privee'=> 'Salle_privee'
                ]
            ])
            ->add('description',TextareaType::class,['attr'=>[
                'placeholder'=>'Description...',
                'class'=>'form-control'
            ]])
            ->add('Enregistrer',SubmitType::class)
//            ->add('dateP',DateTimeType::class)
//            ->add('idUtilisateur',EntityType::class,['class'=>Utilisateurs::class,'choice_label'=>'nom'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
