<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;

/**
 * Generate the form for creating new users
 *
 * @author Cindy Clijsters
 */
class CreateType extends AbstractType
{    
    /**
     * Generate the form for creating new users
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
                'username',
                TextType::class,
                [
                    'label'      => 'field.username',
                    'required'   => true,
                    'attr'       => ['maxlength' => 110],
                    'empty_data' => '',
                ]
            )  
            ->add(
                'role',
                 ChoiceType::class,
                [
                    'label'       => 'field.role',
                    'required'    => true,
                    'choices'     => [
                        'role.makeChoice'      => '',
                        'role.ROLE_USER'       => User::ROLE_USER,
                        'role.ROLE_ADMIN'      => User::ROLE_ADMIN,
                        'role.ROLE_SUPERADMIN' => User::ROLE_SUPERADMIN
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label'              => 'action.save',
                    'translation_domain' => 'messages',
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
            'validation_groups'  => 'create',
            'translation_domain' => 'users'
        ]);
    }    
}
