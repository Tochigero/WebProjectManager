<?php

namespace App\Form;

use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForgetPasswordType extends AbstractType
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
            ->add('key', TextType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your key',
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your new password',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => ' ',
            ])
            ->add('token', TextType::class, [
                'label' => ' ',
                'attr' => [
                    'hidden' => 'hidden'
                ]
            ])

        ;
    }
}
