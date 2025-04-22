<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\{
    AbstractType,
    FormBuilderInterface
};
use Symfony\Component\Validator\Constraints\{
    Email,
    NotBlank
};

class UserRegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Email не може бути пустим',
                    ]),
                    new Email([
                        'message' => 'Некоректний формат email',
                    ]),
                ],
            ])
            ->add('password')
            ->add('name')
            ->add('age')
            ->add('weight')
            ->add('height')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
