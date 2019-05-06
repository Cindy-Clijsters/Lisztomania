<?php
declare(strict_types = 1);

namespace App\Form\Label;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Label;

/**
 * Generate the form for filtering labels
 *
 * @author Cindy Clijsters
 */
class FilterType extends AbstractType
{
    /**
     * Build the form for filtering distributors
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
                        'maxlength'   => 50,
                        'placeholder' => 'field.searchValue'
                    ]
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label'    => 'field.status',
                    'required' => false,
                    'choices'  => [
                        'status.makeChoice' => '',
                        'status.active'     => Label::STATUS_ACTIVE,
                        'status.inactive'   => Label::STATUS_INACTIVE
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
            'translation_domain' => 'labels',
            'validation_groups'  => 'filter',
            'csfr_protection'    => false
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
