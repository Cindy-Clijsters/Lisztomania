<?php
declare(strict_types = 1);

namespace App\Form\Artist;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Choice;
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
                    'label'    => 'field.name',
                    'required' => true,
                    'attr'     => ['maxlength' => 100]
                ]
            )
            ->add(
                'sortName',
                TextType::class,
                [
                    'label'    => 'field.sortName',
                    'required' => true,
                    'attr'     => ['maxlength' => 100]
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'field.status',
                    'required' => true,
                    'constraints' => [
                        new Choice([
                            'choices' => ['', Artist::STATUS_ACTIVE, Artist::STATUS_INACTIVE]
                        ])
                    ],
                    'choices' => [
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
            'translation_domain' => 'artists'
        ]);
    }
}
