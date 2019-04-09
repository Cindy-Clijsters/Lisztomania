<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\User;

/**
 * Generate the form for updating own passwords
 *
 * @author Cindy Clijsters
 */
class UpdatePasswordType extends AbstractType
{
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }
    
    /**
     * Build the form
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
                    'label'      => 'field.oldPassword',
                    'required'   => true,
                    'empty_data' => '',
                    'attr'       => ['maxlength' => 50]
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label'      => 'field.password',
                    'required'   => true,
                    'empty_data' => '',
                    'attr'       => ['maxlength' => 50]
                ]
            )
            ->add(
                'confirmPassword',
                PasswordType::class,
                [
                    'label'      => 'field.confirmPassword',
                    'required'   => true,
                    'empty_data' => '',
                    'attr'       => ['maxlength' => 50]
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
            'data_class'         => User::class,
            'validation_groups'  => 'updatePassword',
            'translation_domain' => 'users',
        ]);
    }
}
