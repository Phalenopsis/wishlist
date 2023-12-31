<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\WishList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name');
    }

//    public function buildForm(FormBuilderInterface $builder, array $options): void
//    {
//        $builder
//            ->add('name')
//            ->add('creator', EntityType::class, [
//                'class' => User::class,
//'choice_label' => 'id',
//            ])
//            ->add('contributors', EntityType::class, [
//                'class' => User::class,
//'choice_label' => 'id',
//'multiple' => true,
//            ])
//        ;
//    }

//    public function addFriendForm(FormBuilderInterface $builder, array $options): void
//    {
//        $builder
//            ->add('contributors', EntityType::class, [
//                'class' => User::class,
//                'choice_label' => 'id',
//                'multiple' => true,
//            ])
//        ;
//    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => WishList::class,
        ]);
    }
}
