<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Distributor;

/**
 * Hold twig extensions for the distributors
 *
 * @author Cindy Clijsters
 */
class DistributorExtension extends AbstractExtension
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
     * Get an overview of the distributor filters
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('formatDistributorStatus', [$this, 'formatDistributorStatusFilter'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];
    }
    
    /**
     * Translate and format the distributor status
     *
     * @param string $status
     * 
     * @return string
     */
    public function formatDistributorStatusFilter(string $status): string
    {
        $class       = $this->getDistributorStatusClass($status);
        $translation = $this->translator->trans('status.' . $status, [], 'distributors');
        
        return '<span class="' . $class . '">' . $translation . '</span>';
    }
    
    /**
     * Get the class of the distributor
     * 
     * @param string $status
     * 
     * @return string
     */
    private function getDistributorStatusClass(string $status): string
    {
        switch ($status) {
            case Distributor::STATUS_ACTIVE:
                $class = 'badge badge-success';
                break;
            case Distributor::STATUS_INACTIVE:
                $class = 'badge badge-danger';
                break;
            case Distributor::STATUS_DELETED:
                $class = 'badge badge-dark';
                break;
            default:
                $class = 'badge badge-light';
                break;
        }
        
        return $class;
    }
}
