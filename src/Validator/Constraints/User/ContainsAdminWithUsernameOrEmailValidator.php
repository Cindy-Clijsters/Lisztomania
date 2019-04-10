<?php
declare(strict_types = 1);

namespace App\Validator\Constraints\User;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

use App\Service\UserService;

/**
 * Check if the field contains an administrator or superadministrator with this username or e-mail address
 *
 * @author Cindy Clijsters
 */
class ContainsAdminWithUsernameOrEmailValidator extends ConstraintValidator
{
    private $userSvc;
    
    /**
     * Constructor
     * 
     * @param UserService $userService
     */
    public function __construct(UserService $userService) 
    {
        $this->userSvc = $userService;
    }
    
    /**
     * Check if the field contains an administrator or superadministrator with this username or e-mail address
     * 
     * @param $value
     * @param Constraint $constraint
     * 
     * @return boolean
     */
    public function validate($value, Constraint $constraint): bool
    {
        $user = $this->userSvc->findAdminByUsernameOrEmail($value);
        
        if ($user === null) {
            $this->context->buildViolation($constraint->message)
                ->atPath('usernameOrEmail')
                ->addViolation();
            
            return false;
        }
        
        return true;
    }
}
