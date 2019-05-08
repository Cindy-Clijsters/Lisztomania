<?php
declare(strict_types = 1);

namespace App\Form\Album;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Label;
use App\Entity\Distributor;
use App\Service\AlbumService;
use App\Service\ArtistService;
use App\Service\LabelService;
use App\Service\DistributorService;

/**
 * Generate the form for filtering the albums
 *
 * @author Cindy Clijsters
 */
class FilterType extends AbstractType
{
    private $albumSvc;
    private $artistSvc;
    private $labelSvc;
    private $distributorSvc;
    
    /**
     * Constructor function
     * 
     * @param AlbumService $albumService
     * @param ArtistService $artistService
     * @param LabelService $labelService
     * @param DistributorService $distributorService
     */
    public function __construct(
        AlbumService $albumService,
        ArtistService $artistService,
        LabelService $labelService,
        DistributorService $distributorService
    ){
        $this->albumSvc       = $albumService;
        $this->artistSvc      = $artistService;
        $this->labelSvc       = $labelService;
        $this->distributorSvc = $distributorService;
    }
    
    /**
     * Generate the form for filtering albums
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
                'multipleArtists',
                CheckboxType::class,
                [
                    'label'      => 'field.multipleArtists',
                    'value'      => true,
                    'required'   => false,
                    'empty_data' => null
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
                ChoiceType::class,
                [
                    'label'                     => 'field.releaseYear',
                    'required'                  => false,
                    'placeholder'               => 'releaseYear.makeChoice',
                    'empty_data'                => null,
                    'choices'                   => $this->albumSvc->getReleaseYearArray(),
                    'choice_translation_domain' => false
                ]
            )       
            ->add(
                'status',
                ChoiceType::class,
                [
                    'label'       => 'field.status',
                    'required'    => true,
                    'choices'     => [
                        'status.makeChoice' => '',
                        'status.active'   => Album::STATUS_ACTIVE,
                        'status.inactive' => Album::STATUS_INACTIVE
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
            'translation_domain' => 'albums',
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
