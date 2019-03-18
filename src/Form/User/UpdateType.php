<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;

/**
 * Generate the form for updating a user
 *
 * @author Cindy Clijsters
 */
class UpdateType extends AbstractType
{
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
                'role',
                 ChoiceType::class,
                [
                    'label'       => 'field.role',
                    'required'    => true,
                    'constraints' => [
                        new Choice([
                            'choices' => ['', User::ROLE_ADMIN, User::ROLE_SUPERADMIN, User::ROLE_USER]
                        ])
                    ],
                    'choices'     => [
                        'role.makeChoice'      => '',
                        'role.ROLE_USER'       => User::ROLE_USER,
                        'role.ROLE_ADMIN'      => User::ROLE_ADMIN,
                        'role.ROLE_SUPERADMIN' => User::ROLE_SUPERADMIN
                    ]
                ]
            )
            ->add(
                'status',
                 ChoiceType::class,
                [
                    'label'              => 'field.status',
                    'required'           => true,
                    'constraints'        => [
                        new Choice([
                            'choices' => ['', User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_UNCONFIRMED]
                        ])
                    ],
                    'choices'     => [
                        'status.makeChoice'  => '',
                        'status.active'      => User::STATUS_ACTIVE,
                        'status.inactive'    => User::STATUS_INACTIVE,
                        'status.unconfirmed' => User::STATUS_UNCONFIRMED
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
            'validation_groups'  => 'update',
            'translation_domain' => 'users'
        ]);
    }      
}
