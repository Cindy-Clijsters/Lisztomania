<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

use App\Validator\Constraints\User\ContainsAdminWithUsernameOrEmail;

/**
 * Generate the form for requesting a password reset
 *
 * @author Cindy Clijsters
 */
class ForgotYourPasswordType extends AbstractType
{
    /**
     * Generate the form for requesting a password reset
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->add(
                'usernameOrEmail',
                TextType::class,
                [
                    'label'       => 'field.usernameOrEmail',
                    'required'    => true,
                    'attr'        => ['maxlength' => 180],
                    'constraints' => [
                        new NotBlank(),
                        new Length(['max' => 180]),
                        new ContainsAdminWithUsernameOrEmail()
                    ]
                ]
            )
            ->add(
                'send',
                SubmitType::class,
                [
                    'label'              => 'action.send',
                    'translation_domain' => 'messages'
                ]
            );
    }
    
    /**
     * Set the default options
     * 
     * @param OptionsResolver $resolver
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'users'
        ]);
    }
}
