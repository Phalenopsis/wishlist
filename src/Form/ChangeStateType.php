<?php

namespace App\Form;

use App\Entity\Label;
use App\Entity\Proposition;
use App\Entity\User;
use App\Entity\WishList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Config\State;
use Symfony\Component\Form\Extension\Core\Type\EnumType;

class ChangeStateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'Créé' => 'Created',
                    'En attente de réalisation' => 'Pending',
                    'Rejeté' => 'Rejected',
                    'Réalisé' => 'Done'
                ],
                'multiple' => false,
                'expanded' => true,
                'by_reference' => false,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,
        ]);
    }
}
