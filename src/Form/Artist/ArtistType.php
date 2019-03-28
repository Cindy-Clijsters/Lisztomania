<?php
declare(strict_types = 1);

namespace App\Form\Artist;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Artist;

/**
 * Generate the form for the artists
 *
 * @author Cindy Clijsters
 */
class ArtistType extends AbstractType
{
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
                    'empty_data' => '',
                ]
            )
            ->add(
                'sortName',
                TextType::class,
                [
                    'label'      => 'field.sortName',
                    'required'   => true,
                    'attr'       => ['maxlength' => 100],
                    'empty_data' => ''
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label'       => 'field.status',
                    'required'    => true,
                    'empty_data'  => '',
                    'choices'     => [
                        'status.makeChoice' => '',
                        'status.active'     => Artist::STATUS_ACTIVE,
                        'status.inactive'   => Artist::STATUS_INACTIVE
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
    
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'validation_groups'  => 'create',
            'translation_domain' => 'artists',
            'data_class'         => Artist::class
        ]);
    }
}
