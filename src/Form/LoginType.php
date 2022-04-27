<?php

namespace App\Form;

use App\Entity\Utilisateurs;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',EmailType::class, [
                'label'=>'Votre email',
                ])
            ->add('mdp',PasswordType::class,[
                'label'=>'Votre mot de passe',
                ])
             ->add('Submit',SubmitType::class)
             ->add('captchaCode', CaptchaType::class, array(
            'captchaConfig' => 'AuthCaptcha'
));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateurs::class,
            'validation_groups' => ['authentification'],
        ]);
    }
}
