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
 * Generate the form for the labels
 *
 * @author Cindy Clijsters
 */
class LabelType extends AbstractType
{
    /**
     * Build the form for the labels
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
                    'label' => 'field.name',
                    'required' => true,
                    'attr' => ['maxlength' => 100]
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'field.status',
                    'required' => true,
                    'choices' => [
                        'status.makeChoice' => '',
                        'status.active'     => Label::STATUS_ACTIVE,
                        'status.inactive'   => Label::STATUS_INACTIVE
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
            'validation_groups'  => 'create',
            'translation_domain' => 'labels'
        ]);
    }
}
