<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Label;

/**
 * Holds twig extensions for the labels
 *
 * @author Cindy Clijsters
 */
class LabelExtension extends AbstractExtension
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
     * Get an overview of the label filters
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('formatLabelStatus', [$this, 'formatLabelStatusFilter'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];
    }
    
    /**
     * Translate and format the label status
     *
     * @param string $status
     * 
     * @return string
     */
    public function formatLabelStatusFilter(string $status): string
    {
        $class       = $this->getLabelStatusClass($status);
        $translation = $this->translator->trans('status.' . $status, [], 'labels');
        
        return '<span class="' . $class . '">' . $translation . '</span>';
    }
    
    /**
     * Get the class of the label
     * 
     * @param string $status
     * 
     * @return string
     */
    private function getLabelStatusClass(string $status): string
    {
        switch ($status) {
            case Label::STATUS_ACTIVE:
                $class = 'badge badge-success';
                break;
            case Label::STATUS_INACTIVE:
                $class = 'badge badge-danger';
                break;
            case Label::STATUS_DELETED:
                $class = 'badge badge-dark';
                break;
            default:
                $class = 'badge badge-light';
                break;
        }
        
        return $class;
    }
}
