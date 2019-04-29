<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Translation\TranslatorInterface;

use Symfony\Component\Intl\Intl;

use App\Entity\Artist;

/**
 * Holds twig extensions for the artists
 *
 * @author Cindy Clijsters
 */
class ArtistExtension extends AbstractExtension
{
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }  
    
    /**
     * Get an overview of user filters
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('formatArtistStatus', [$this, 'formatArtistStatusFilter'], ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new \Twig_SimpleFilter('countryName', [$this, 'getCountryName'])
        ];        
    }    
    
    /**
     * Translate and format the artist status
     * 
     * @param string $status
     * 
     * @return string
     */
    public function formatArtistStatusFilter(string $status): string
    {
        $class       = $this->getArtistStatusClass($status);
        $translation = $this->translator->trans('status.' . $status, [], 'artists');
        
        return '<span class="' . $class . '">' . $translation . '</span>';
    }    
    
    /**
     * Get the class of the artist status
     * 
     * @param string $status
     * 
     * @return string
     */
    private function getArtistStatusClass(string $status): string
    {
        switch($status) {
            case Artist::STATUS_ACTIVE:
                $class = 'badge badge-success';
                break;
            case Artist::STATUS_INACTIVE:
                $class = 'badge badge-danger';
                break;
            default:
                $class = 'badge badge-light';
                break;
        }
        
        return $class;
    }    
    
    /**
     * Get the full country name
     * 
     * @param string $countryAbbr
     * 
     * @return string
     */
    public function getCountryName(string $countryAbbr): string
    {
        return Intl::getRegionBundle()->getCountryName($countryAbbr);
    }       
}
