<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Generate the form for updating your profile information
 *
 * @author Cindy Clijsters
 */
class UpdateMyProfileType extends AbstractType
{
    /**
     * Generate the form for updating your profile information
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
                'lastName',
                TextType::class,
                [
                    'label'    => 'field.lastName',
                    'required' => true,
                    'attr'     => ['maxlength' => 50]
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    'label'    => 'field.firstName',
                    'required' => true,
                    'attr'     => ['maxlength' => 50]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label'    => 'field.email',
                    'required' => true,
                    'attr'     => ['maxlength' => 180]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
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
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'users'
        ]);
    }
}
