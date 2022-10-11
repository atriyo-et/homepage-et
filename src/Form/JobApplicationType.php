<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class JobApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jobPosition', TextType::class, [
                'required' => true,
                'label' => false,
                'constraints' => new NotBlank(),
                'attr' => [
                    'placeholder' => 'career.application_form.job_posting',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'constraints' => new NotBlank(),
                'attr' => [
                    'placeholder' => 'career.application_form.name',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('candidateEmail', EmailType::class, [
                'required' => true,
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'attr' => [
                    'placeholder' => 'career.application_form.email',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('phone', TextType::class, [
                'required' => true,
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'career.application_form.phone',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('cv', FileType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('message', TextareaType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'rows' => 4,
                    'placeholder' => 'career.application_form.message',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'job_application_no_guess',
        ]);
    }
}
