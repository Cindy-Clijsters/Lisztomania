<?php
declare(strict_types = 1);

namespace App\Controller\Artist;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Artist;
use App\Form\Artist\ArtistType;

/**
 * Create a artist
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    private $em;
    private $translator;
    
    /**
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     */
    public function __construct(EntityManagerInterface $em, TranslatorInterface $translator)
    {
        $this->em         = $em;
        $this->translator = $translator;
    }
    
    /**
     * Create a new artist
     * 
     * @Route({
     *  "nl" : "/beheer/artiesten/toevoegen",
     *  "en" : "/admin/artists/add"
     * }, name="rtAdminArtistCreate")
     * 
     * @param Request $request
     * 
     * @return Response
     */
   public function create(Request $request): Response
   {
       // Generate the form
       $artist = new Artist();
       $form   = $this->createForm(ArtistType::class, $artist);
       
       $form->handleRequest($request);
       
       if ($form->isSubmitted() && $form->isValid()) {
           
           // Get the posted values
           $artist = $form->getData();
           
           // Save the artist
           $this->em->persist($artist);
           $this->em->flush();
           
           // Redirect to the overview
           $this->addFlash(
               'notice',
               $this->translator->trans(
                    'msg.addedSuccessfully',
                    [
                        '%name%' => $artist->getName()
                    ],
                    'artists'
               )
           );
           
           return $this->redirectToRoute('rtAdminArtistOverview');
           
       }
       
       // Display the view
       return $this->render(
           'artist/create.html.twig',
            [
                'form' => $form->createView()
            ]
       );
   }
}
