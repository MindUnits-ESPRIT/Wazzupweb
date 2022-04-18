<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('datenaissance', DateType::class, array(
                'required' => true,
                'widget' => 'single_text',
                'label' => 'Date of Birth',
                'attr' => ['class' => 'form-control input-inline datetimepicker'],
            ))
            ->add('genre')
            ->add('numTel',TelType::class)
            ->add('email')
            ->add('avatar')
            ->add('oldmdp',PasswordType::class)
            ->add('mdp',PasswordType::class)
            ->add('mdpconfirm',PasswordType::class)
            ->add('avatar',FileType::class)
            ->add('Submit',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
        ]);
    }
}
