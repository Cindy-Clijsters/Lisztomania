<?php
declare(strict_types = 1);

namespace App\Validator\Constraints\Album;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Check if the album is linked to multiple artist or one single artist
 *
 * @author Cindy Clijsters
 */
class SelectAlbumArtistValidator extends ConstraintValidator
{
    /**
     * Check if the album is linked to multiple artist or one single artist
     * 
     * @param $album
     * @param Constraint $constraint
     * 
     * @return boolean
     */
    public function validate($album, Constraint $constraint): bool
    {                
        if (
            $album->getMultipleArtists() === false
            && $album->getArtist() === null
        ) {
            $this->context->buildViolation('')
                ->atPath('multipleArtists')
                ->addViolation();
                        
            $this->context->buildViolation($constraint->message)
                ->atPath('artist')
                ->addViolation();
            
            return false;
        }

        return true;
    }
}
