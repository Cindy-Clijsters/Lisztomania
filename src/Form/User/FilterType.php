<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\User;

/**
 * Generate the form for filtering the users
 *
 * @author Cindy Clijsters
 */
class FilterType extends AbstractType
{
    /**
     * Generate the form for filtering users
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     * 
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder 
            ->setMethod('GET')
            ->add(
                'searchValue',
                TextType::class,
                [
                    'label'      => 'field.searchValue',
                    'required'   => false,
                    'empty_data' => '',
                    'attr'       => [
                        'maxlength'   => 100,
                        'placeholder' => 'field.searchValue'
                    ]
                ]
            )
            ->add(
                'role',
                 ChoiceType::class,
                [
                    'label'       => 'field.role',
                    'required'    => false,
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
                    'label'    => 'field.status',
                    'required' => true,
                    'choices'  => [
                        'status.makeChoice'  => '',
                        'status.active'      => User::STATUS_ACTIVE,
                        'status.inactive'    => User::STATUS_INACTIVE,
                        'status.unconfirmed' => User::STATUS_UNCONFIRMED
                    ]
                ]
            )
            ->add(
                'filter',
                SubmitType::class,
                [
                    'label'              => 'action.filter',
                    'translation_domain' => 'messages'
                ]
            );                
               
    }
    
    /**
     * Set the default values
     * 
     * @param OptionsResolver $resolver
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'translation_domain' => 'users',
            'validation_groups'  => 'filter',
            'crsf_protection'    => false
        ]);
    }
    
    /**
     * Set the block prefix of the form
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
