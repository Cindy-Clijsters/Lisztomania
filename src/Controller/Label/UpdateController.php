<?php
declare(strict_types = 1);

namespace App\Controller\Label;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Update a label
 *
 * @author Cindy Clijsters
 */
class UpdateController extends AbstractController
{
    /**
     * Update a label
     * 
     * @Route({
     *  "nl" : "/beheer/labels/wijzigen/{id}",
     *  "en" : "/admin/labels/update/{id}"
     * }, name="rtAdminLabelUpdate")
     * 
     * @param int $id
     * 
     * @return Response
     */
    public function update(int $id): Response
    {
        return $this->render(
            'label/update.html.twig'
        );
    }
}
