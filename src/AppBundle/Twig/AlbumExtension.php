<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Album;

/**
 * Holds twig extensions for the albums
 * 
 * @author Cindy Clijsters
 */
class AlbumExtension extends AbstractExtension
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
            new \Twig_SimpleFilter('formatAlbumStatus', [$this, 'formatAlbumStatusFilter'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];        
    }    
    
    /**
     * Translate and format the artist status
     * 
     * @param string $status
     * 
     * @return string
     */
    public function formatAlbumStatusFilter(string $status): string
    {
        $class       = $this->getAlbumStatusClass($status);
        $translation = $this->translator->trans('status.' . $status, [], 'albums');
        
        return '<span class="' . $class . '">' . $translation . '</span>';
    }    
    
    /**
     * Get the class of the album status
     * 
     * @param string $status
     * 
     * @return string
     */
    private function getAlbumStatusClass(string $status): string
    {
        switch($status) {
            case Album::STATUS_ACTIVE:
                $class = 'badge badge-success';
                break;
            case Album::STATUS_INACTIVE:
                $class = 'badge badge-danger';
                break;
            case Album::STATUS_DELETED:
                $class = 'badge badge-dark';
                break;
            default:
                $class = 'badge badge-light';
                break;
        }
        
        return $class;
    }    
}
