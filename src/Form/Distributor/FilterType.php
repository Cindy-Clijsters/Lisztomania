<?php
declare(strict_types = 1);

namespace App\Form\Distributor;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Distributor;

/**
 * Generate the form for filtering distributors
 *
 * @author Cindy Clijsters
 */
class FilterType extends AbstractType
{
    /**
     * Build a form for filtering distributors
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
                    'label'       => 'field.searchValue',
                    'required'    => false,
                    'empty_data'  => '',
                    'attr'        => [
                        'maxlength'   => 50,
                        'placeholder' => 'field.searchValue'
                    ]
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label'       => 'field.status',
                    'required'    => false,
                    'choices'     => [
                        'status.makeChoice' => '',
                        'status.active'     => Distributor::STATUS_ACTIVE,
                        'status.inactive'   => Distributor::STATUS_INACTIVE
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
            'translation_domain' => 'distributors',
            'validation_groups'  => 'filter',
            'csrf_protection'    => false
        ]);
    }
    
    /**
     * Set the block prefix of the form
     * 
     * @return string
     */
    public function getBlockPrefix()
    {
        return '';
    }
}
