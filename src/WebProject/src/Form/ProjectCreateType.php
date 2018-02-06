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

class ProjectCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('admin', EmailType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your email',
                ]
            ])
            ->add('password', PasswordType::class, [
                'label' => ' ',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Your password',
                    'min' => '5'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => ' ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
