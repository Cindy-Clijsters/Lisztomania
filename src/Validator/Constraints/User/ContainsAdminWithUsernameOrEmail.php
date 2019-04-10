<?php
declare(strict_types = 1);

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;

/**
 * Check if the field contains an administrator or superadministrator with this username or e-mail address
 * 
 * @Annotation
 *
 * @author Cindy Clijsters
 */
class ContainsAdminWithUsernameOrEmail extends Constraint
{
    public $message = "error.usernameOrEmailNotFound";
    
    
}
