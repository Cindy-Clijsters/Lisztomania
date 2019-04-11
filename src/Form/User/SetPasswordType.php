<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;

/**
 * Generate the form for setting resetting the password
 *
 * @author Cindy Clijsters
 */
class SetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label'      => 'field.password',
                    'required'   => true,
                    'empty_data' => '',
                    'attr'       => ['maxlength' => 150]
                ]
            )
            ->add(
               'confirmPassword',
               PasswordType::class,
               [
                   'label'      => 'field.confirmPassword',
                   'required'   => true,
                   'empty_data' => '',
                   'attr'       => ['maxlength' => 150]
               ]
            )
            ->add(
                'submit',
                SubmitType::Class,
                [
                    'label'              => 'action.save',
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
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => User::class,
            'validation_groups'  => '',
            'translation_domain' => 'users'
        ]);
    }
}
