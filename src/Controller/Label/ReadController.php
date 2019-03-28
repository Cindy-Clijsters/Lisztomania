<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Read the information of a label
 *
 * @author Cindy Clijsters
 */
class ReadController extends AbstractController
{
    /**
     * Read the information of a label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/bekijken/{id}",
     *  "en" : "/admin/labels/view/{id}"
     * }, name="rtAdminLabelRead")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function read(int $id): Response
    {
        return $this->render(
            'label/read.html.twig'
        );
    }
}
