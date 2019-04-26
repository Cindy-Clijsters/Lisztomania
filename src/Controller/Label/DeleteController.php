<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
    private $translator;

    /**
     * Constructor function
     * 
     * @param LabelService $labelService
     * @param AlbumService $albumService
     * @param TranslatorInterface $translator
     */
    public function __construct(
        LabelService $labelService,
        AlbumService $albumService,
        TranslatorInterface $translator
    ) {
        $this->labelSvc   = $labelService;
        $this->albumSvc   = $albumService;
        $this->translator = $translator;        
    }
    
    /**
     * Delete a label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/verwijderen/{slug}",
     *  "en" : "/admin/labels/delete/{slug}"
     * }, name="rtAdminLabelDelete")
     * 
     * @param string $slug
     * 
     * @return Response
     */
    public function delete(string $slug): Response
    {
        // Get the information of the label
        $label = $this->labelSvc->findBySlug($slug);
        
        // Check if the label is connected to an album
        $albumCount = $this->albumSvc->countAlbumsByLabel($label);
        
        if ($albumCount === 0) {
            
            // Save the label
            $this->labelSvc->removeFromDb($label);
            
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
            'label/delete.html.twig',
            [
                'label' => $label
            ]
        );
        
    }
}
