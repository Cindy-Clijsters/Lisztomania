<?php
declare(strict_types = 1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Label;
use App\Entity\Distributor;
use App\Service\ArtistService;
use App\Service\LabelService;
use App\Service\DistributorService;

/**
 * Generate the form for the albums
 *
 * @author Cindy Clijsters
 */
class AlbumType extends AbstractType
{
    private $artistSvc;
    private $labelSvc;
    private $distributorSvc;
    
    /**
     * Constructor function
     * 
     * @param ArtistService $artistService
     * @param LabelService $labelService
     * @param DistributorService $distributorService
     */
    public function __construct(
        ArtistService $artistService,
        LabelService $labelService,
        DistributorService $distributorService
    ){
        $this->artistSvc      = $artistService;
        $this->labelSvc       = $labelService;
        $this->distributorSvc = $distributorService;
    }
    
    /**
     * Build the form for creating/updating albums
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
                'multipleArtists',
                CheckboxType::class,
                [
                    'label'      => 'field.multipleArtists',
                    'value'      => true,
                    'required'   => false,
                    'empty_data' => 0
                ]
            )
            ->add(
                'artist',
                EntityType::class,
                [
                    'label'        => 'field.artist',
                    'class'        => Artist::class,
                    'choices'      => $this->artistSvc->findActive(),
                    'choice_label' => 'sortName',
                    'placeholder'  => 'artist.makeChoice',
                    'empty_data'   => null,
                    'required'     => false
                ]
            )
            ->add(
                'title',
                TextType::class,
                [
                    'label'      => 'field.title',
                    'required'   => true,
                    'attr'       => ['maxlength' => 100],
                    'empty_data' => ''
                ]
            )
            ->add(
                'alternativeTitle',
                TextType::class,
                [
                    'label'      => 'field.alternativeTitle',
                    'required'   => false,
                    'attr'       => ['maxlength' => 100],
                    'empty_data' => null
                ]
            )
            ->add(
                'label',
                EntityType::class,
                [
                    'label'        => 'field.label',
                    'class'        => Label::class,
                    'choices'      => $this->labelSvc->findActive(),
                    'choice_label' => 'name',
                    'placeholder'  => 'label.makeChoice',
                    'empty_data'   => null,
                    'required'     => false
                ]
            )
            ->add(
                'distributor',
                EntityType::class,
                [
                    'label'        => 'field.distributor',
                    'class'        => Distributor::class,
                    'choices'      => $this->distributorSvc->findActive(),
                    'choice_label' => 'name',
                    'placeholder'  => 'distributor.makeChoice',
                    'empty_data'   => null,
                    'required'     => false
                ]
            )
            ->add(
                'releaseYear',
                TextType::class,
                [
                    'label'      => 'field.releaseYear',
                    'required'   => false,
                    'attr'       => ['maxlength' => 4],
                    'empty_data' => null
                ]
            )                
            ->add(
                'releaseDate',
                DateType::class,
                [
                    'label'      => 'field.releaseDate',
                    'required'   => false,
                    'attr'       => ['maxlength' => 10],
                    'format'     => 'dd-MM-yyyy',
                    'empty_data' => null,
                    'widget'     => 'single_text',
                    //'years'      => range(date('Y') + 1, 1950)
                    
                ]
            )
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label' => 'field.status',
                    'required' => true,
                    'empty_data' => '',
                    'choices' => [
                        'status.makeChoice' => '',
                        'status.active'     => Album::STATUS_ACTIVE,
                        'status.inactive'   => Album::STATUS_INACTIVE
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
            'translation_domain' => 'albums',
            'data_class'         => Album::class
        ]);
    }
}
