<?php

namespace App\Form;

use App\Entity\User; // Use the new entity class name
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;

class UserFormType extends AbstractType // Change the class name
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'required' => true,
                'attr' => ['maxlength' => 255],
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'attr' => ['maxlength' => 255],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Change to the new entity class name
        ]);
    }
}
