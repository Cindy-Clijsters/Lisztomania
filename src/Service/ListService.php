<?php
declare(strict_types = 1);

namespace App\Service;

/**
 * Hold services for generating the overview lists
 *
 * @author Cindy Clijsters
 */
class ListService
{
    /**
     * Calculate the start- and endrecord of the shown items
     * 
     * @param int $currentPageNr
     * @param int $itemsByPage
     * @param int $totalItems
     * 
     * @return array
     */
    public function getStartEndRecord(
        int $currentPageNr,
        int $itemsByPage,
        int $totalItems
    ): array {
        
        $startRecord = ($currentPageNr - 1) * $itemsByPage + 1;
        $endRecord   = $startRecord + $itemsByPage - 1;
        
        if ($endRecord > $totalItems) {
            $endRecord = $totalItems;
        }
        
        return [$startRecord, $endRecord];
        
    }
}
