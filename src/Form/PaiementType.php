<?php

namespace App\Form;

use App\Entity\Paiement;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class PaiementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
//            ->add('datePaiement')
            ->add('methodePaiement', ChoiceType::class, ['choices' => ['Choisir la methode du paiement' => 'C', 'paypal' => 'p', 'stripe' => 's']])
            ->add('prix');
    }

}