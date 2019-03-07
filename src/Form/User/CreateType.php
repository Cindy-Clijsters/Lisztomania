<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Choice;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\User;

/**
 * Generate the form for creating new users
 *
 * @author Cindy Clijsters
 */
class CreateType extends AbstractType
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
                    'label'    => $this->translator->trans('Last name', [], 'users'),
                    'required' => true,
                    'attr'     => ['maxlength' => 50]
                ]
            )
            ->add(
                'firstName',
                TextType::class,
                [
                    'label'    => $this->translator->trans('First name', [], 'users'),
                    'required' => true,
                    'attr'     => ['maxlength' => 50]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label'    => $this->translator->trans('E-mail address', [], 'users'),
                    'required' => true,
                    'attr'     => ['maxlength' => 180]
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label'    => $this->translator->trans('Wachtwoord', [], 'users'),
                    'required' => true,
                    'attr'     => ['maxlength' => 50]
                ]
            )
            ->add(
                'confirmPassword',
                PasswordType::class,
                [
                    'label'    => $this->translator->trans('Confirm password', [], 'users'),
                    'required' => true,
                    'attr'     => ['maxlength' => 50]
                ] 
            )
            /*    
            ->add(
                'roles',
                 ChoiceType::class,
                [
                    'label'       => $this->translator->trans('Role', [], 'users'),
                    'required'    => true,
                    'constraints' => [
                        new Choice([
                            'choices' => ['', User::ROLE_ADMIN, User::ROLE_SUPERADMIN, User::ROLE_USER], 
                            'message' => "De status moet een geldige waarde bevatten."
                        ])
                    ],
                    'choices'     => [
                        ''                                                       => '',
                        $this->translator->trans('ROLE_USER', [], 'users')       => User::ROLE_USER,
                        $this->translator->trans('ROLE_ADMIN', [], 'users')      => User::ROLE_ADMIN,
                        $this->translator->trans('ROLE_SUPERADMIN', [], 'users') => User::ROLE_SUPERADMIN
                    ]
                ]
            )
             */
            ->add(
                'status',
                 ChoiceType::class,
                [
                    'label'       => $this->translator->trans('Status'),
                    'required'    => true,
                    'constraints' => [
                        new Choice([
                            'choices' => ['', User::STATUS_ACTIVE, User::STATUS_INACTIVE, User::STATUS_UNCONFIRMED], 
                            'message' => "De status moet een geldige waarde bevatten."
                        ])
                    ],
                    'choices'     => [
                        ''                                                   => '',
                        $this->translator->trans('active', [], 'users')      => User::STATUS_ACTIVE,
                        $this->translator->trans('inactive', [], 'users')    => User::STATUS_INACTIVE,
                        $this->translator->trans('unconfirmed', [], 'users') => User::STATUS_UNCONFIRMED
                    ]
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => $this->translator->trans('Save')
                ]
            );
    }
}
