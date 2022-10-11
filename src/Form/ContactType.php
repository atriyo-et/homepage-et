<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => false,
                'constraints' => new NotBlank(),
                'attr' => [
                    'placeholder' => 'contact_us.form.name',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('contactEmail', EmailType::class, [
                'required' => true,
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'attr' => [
                    'placeholder' => 'contact_us.form.email',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('subject', TextType::class, [
                'required' => true,
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'contact_us.form.subject',
                    'class' => 'form-control-lg bg-dark text-white',
                ],
            ])
            ->add('message', TextareaType::class, [
                'required' => false,
                'label' => false,
                'constraints' => [
                    new NotBlank(),
                    new Length(min: 20),
                ],
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'contact_us.form.message',
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
            'csrf_token_id' => 'contact_us_no_guess',
        ]);
    }
}
