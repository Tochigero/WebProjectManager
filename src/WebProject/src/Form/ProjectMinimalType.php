<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectMinimalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Project Code Words',
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your password',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => ' ',
                'attr' => [
                    'hidden' => 'hidden'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
