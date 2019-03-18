<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;

/**
 * Holds general twig extensions
 *
 * @author Cindy Clijsters
 */
class GeneralExtension extends AbstractExtension 
{
    /**
     * Get the overview of general functions
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('formatMailTo', [$this, 'formatMailTo'], ['pre_escape' => 'html', 'is_safe' => ['html']])
        ];
    }
    
    /**
     * Display the text as an mail address
     * 
     * @param string $text
     * 
     * @return string
     */
    public function formatMailTo(string $text): string
    {
        $mails = [];
        
        if (preg_match_all('/[\p{L}0-9_.-]+@[0-9\p{L}.-]+\.[a-z.]{2,6}\b/u', $text, $mails)) {
            foreach ($mails[0] as $mail) {
                $text = str_replace($mail, '<a href="mailto:' . $mail . '" class="colored">' . $mail . '<a>', $text);
            }
        }

        return $text;
    }
    
}
