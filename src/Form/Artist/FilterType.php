<?php
declare(strict_types = 1);

namespace App\Form\Artist;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Artist;

/**
 * Generate the form for filtering artist
 *
 * @author Cindy Clijsters
 */
class FilterType extends AbstractType
{
    /**
     * Generate the form for filtering artists
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
                'country',
                CountryType::class,
                [
                    'label'                     => 'field.country',
                    'required'                  => false,
                    'choice_translation_locale' => null,
                    'placeholder'               => 'country.makeChoice',
                    'attr'                      => ['maxlength' => 2]
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'field.status',
                    'required' => false,
                    'choices' => [
                        'status.makeChoice' => '',
                        'status.active'     => Artist::STATUS_ACTIVE,
                        'status.inactive'   => Artist::STATUS_INACTIVE
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
            'translation_domain' => 'artists',
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
