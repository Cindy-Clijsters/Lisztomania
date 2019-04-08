<?php
declare(strict_types = 1);

namespace App\Validator\Constraints\Album;

use Symfony\Component\Validator\Constraint;

/**
 * Check if the album is linked to multiple artist or one single artist
 *
 * @Annotation
 * 
 * @author Cindy Clijsters
 */
class SelectAlbumArtist extends Constraint
{
    public $message = "error.requiredField";
    
    /**
     * Get the target
     * 
     * @return string
     */
    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
