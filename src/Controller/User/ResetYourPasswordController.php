<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Reset your password
 *
 * @author Cindy Clijsters
 */
class ResetYourPasswordController extends AbstractController
{
    /**
     * Reset your password
     * 
     * @Route({
     *   "nl" : "/beheer/wachtwoord-resetten/{identifier}",
     *   "en" : "/admin/reset-password/{identifier}"
     * }, name="rtAdminResetPassword")
     * 
     * @param string $identifier
     * 
     * @return Response
     */
    public function resetYourPassword(string $identifier): Response
    {
        return $this->render(
            'user/resetYourPassword.html.twig'
        );        
    }
}
