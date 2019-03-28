<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Create a label
 *
 * @author Cindy Clijsters
 */
class CreateController extends AbstractController
{
    /**
     * Create a new label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/toevoegen",
     *  "en" : "/admin/labels/add"
     * }, name="rtAdminLabelCreate")
     * 
     * @param Request $request
     * 
     * @return Response
     */
    public function create(Request $request): Response
    {
       return $this->render(
           'label/create.html.twig'
       );        
    }
}
