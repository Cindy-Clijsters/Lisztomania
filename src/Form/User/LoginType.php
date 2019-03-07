<?php
declare(strict_types = 1);

namespace App\Form\User;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Generate the login form
 *
 * @author Cindy Clijsters
 */
class LoginType extends AbstractType
{
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator   = $translator;
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
                'email',
                EmailType::class,
                [
                    'label' => $this->translator->trans('E-mail address', [], 'users'), 
                    'attr'  => [
                        'class' => 'form-control',
                        'value' => $options['lastEmail']
                    ]
                ]
            )
            ->add(
                'plainPassword',
                PasswordType::class,
                [
                    'label' => $this->translator->trans('Password', [], 'users'),
                    'attr'  => ['class' => 'form-control']
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => $this->translator->trans('Login', [], 'users'),
                    'attr'  => ['class' => 'btn btn-success btn-flat m-b-30 m-t-30']
                ]
            );
    }
    
    /**
     * Set the default optiosn
     * 
     * @param OptionsResolver $resolver
     * 
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['lastEmail' => '']);
    }
}
