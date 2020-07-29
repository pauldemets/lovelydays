<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('price')
            ->add('bedNumber')
            ->add('owner', EntityType::class, array(
                'class' => User::class,
                'expanded'     => false,
                'multiple'     => false,
                'query_builder' => function (UserRepository $er) {
                    return $er->createQueryBuilder('u');
                    },
                'choice_label' => function(User $utilisateur) {
                    return $utilisateur->getName();
                }
            ))
            ->add('envoyer', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
