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
 * Generate a form for filling in a password
 *
 * @author Cindy Clijsters
 */
class ConfirmPasswordType extends AbstractType
{
    /**
     * Build the form for filling in a password
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
                'oldPassword',
                PasswordType::class,
                [
                    'label'      => 'field.password',
                    'required'   => true,
                    'empty_data' => '',
                    'attr'       => ['maxlength' => 50]
                ]
            )
            ->add(
                'submit',
                SubmitType::Class,
                [
                    'label'              => 'action.delete',
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
            'data_class'         => User::class,
            'translation_domain' => 'users'
        ]);
    }
}
