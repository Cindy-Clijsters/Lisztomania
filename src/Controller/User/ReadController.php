<?php
declare(strict_types = 1);

namespace App\Controller\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\User;

/**
 * Read the information of  a user
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator) {
        $this->translator = $translator;
    }
    
    /**
     * Read the information of a user
     * 
     * @Route({
     *  "nl" : "/beheer/gebruikers/bekijken/{id}",
     *  "en" : "/admin/users/view/{id}"
     * }, name="rtAdminUserRead")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        // Get the information to display the view
        $userRps = $this->getDoctrine()->getRepository(User::class);
        $user    = $userRps->findById($id);
        
        if (!$user) {
            throw $this->createNotFoundException(
                $this->translator->trans(
                    'error.noArtistWithId',
                    ['%id%' => $id],
                    'users'
                )
            );
        }
        
        // Display the view
        return $this->render(
            'user/read.html.twig',
            [
                'user' => $user
            ]
        );
    }
}