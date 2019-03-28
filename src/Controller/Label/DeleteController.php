<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Delete a label
 *
 * @author Cindy Clijsters
 */
class DeleteController extends AbstractController
{
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
        return $this->render(
            'label/delete.html.twig'
        );
    }
}
