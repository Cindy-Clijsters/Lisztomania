<?php
declare(strict_types = 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Distributor;

/**
 * Generate the form for the distributors
 *
 * @author Cindy Clijsters
 */
class DistributorType extends AbstractType
{
    /**
     * Build the form for the distributors
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
                'name',
                TextType::class,
                [
                    'label'      => 'field.name',
                    'required'   => true,
                    'attr'       => ['maxlength' => 100],
                    'empty_data' => ''
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label'      => 'field.status',
                    'required'   => true,
                    'empty_data' => '',
                    'choices'    => [
                        'status.makeChoice' => '',
                        'status.active'     => Distributor::STATUS_ACTIVE,
                        'status.inactive'   => Distributor::STATUS_INACTIVE
                    ]
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
            'validation_groups'  => '',
            'translation_domain' => 'distributors',
            'data_class'         => Distributor::class
        ]);
    }    
}
