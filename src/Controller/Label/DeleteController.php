<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\Label;
use App\Service\LabelService;
use App\Service\AlbumService;

/**
 * Delete a label
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
    private $labelSvc;
    private $albumSvc;
    private $em;
    private $translator;

    /**
     * Constructor function
     * 
     * @param UserService $userService
     * @param AlbumService $albumService
     * @param EntityManagerInterface $em
     * @param TranslatorInterface $translator
     */
    public function __construct(
        LabelService $labelService,
        AlbumService $albumService,
        EntityManagerInterface $em,
        TranslatorInterface $translator
    ) {
        $this->labelSvc   = $labelService;
        $this->albumSvc   = $albumService;
        $this->em         = $em;
        $this->translator = $translator;        
    }
    
    /**
     * Delete a label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/verwijderen/{id}",
     *  "en" : "/admin/labels/delete/{id}"
     * }, name="rtAdminLabelDelete")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function delete(int $id): Response
    {
        // Get the information of the label
        $label = $this->labelSvc->findById($id);
        
        // Check if the label is connected to an album
        $albumCount = $this->albumSvc->countAlbumsByLabel($label);
        
        if ($albumCount === 0) {
                       
            // Set the status of the label to deleted
            $label->setStatus(Label::STATUS_DELETED);
            
            // Save the label
            $this->em->persist($label);
            $this->em->flush();
            
            // Redirect to the overview
            $this->addFlash(
                'notice',
                $this->translator->trans(
                    'msg.deletedSuccessfully',
                    [
                        '%name%' => $label->getName()
                    ],
                    'labels'
                )
            );
            
            return $this->redirectToRoute('rtAdminLabelOverview');
        }
        
        // Display message that label can't be deleted
        return $this->render(
            'label/delete.html.twig'
        );
        
    }
}
