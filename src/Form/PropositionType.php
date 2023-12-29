<?php

namespace App\Form;

use App\Entity\Label;
use App\Entity\Proposition;
use App\Entity\User;
use App\Entity\WishList;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class PropositionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content')
            ->add('difficulty', RangeType::class, [
                'attr' => [
                    'min' => 1,
                    'max' => 5
                ]
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
                $proposition = $event->getData();
                $form = $event->getForm();
//                $form->add('labels', TextType::class, [
//                   'attr' => ['placeholder' => $proposition->getWishList()->getName()]
//                ]);
//
                if(count($proposition->getWishList()->getLabels()) > 0){
                    $form->add('labels', EntityType::class, [
                        'class' => Label::class,
                        'choices' => $proposition->getWishList()->getLabels(),
                        'choice_label' => 'name',
                        'multiple' => true,
                        'expanded' => true,
                        'by_reference' => false,
                    ]);
                }
            })
//            ->add('creator', EntityType::class, [
//                'class' => User::class,
//'choice_label' => 'id',
//            ])
//            ->add('wish_list', EntityType::class, [
//                'class' => WishList::class,
//'choice_label' => 'id',
////            ])
//            ->add('labels', EntityType::class, [
//                'class' => Label::class,
//                'choice_label' => 'name',
//                'multiple' => true,
//                'expanded' => true,
//                'by_reference' => false,
//            ])
//            ->add('labels', ChoiceType::class, [
//                'choices'  => [
//                    //on met ici l'array de label de wishlist
//                    'Maybe' => null,
//                    'Yes' => true,
//                    'No' => false,
//                ],])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Proposition::class,
        ]);
    }
}
