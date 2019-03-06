<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;

use App\Entity\User;

/**
 * Holds twig extensions for the users
 * 
 * @author Cindy Clijsters
 */
class UserExtension extends AbstractExtension
{
    /**
     * Get an overview of user filters
     * 
     * @return array
     */
    public function getFilters(): array
    {
        return [
            new \Twig_SimpleFilter('formatUserStatus', [$this, 'formatUserStatusFilter'], ['pre_escape' => 'html', 'is_safe' => ['html']]),
            new \Twig_SimpleFilter('userRole', [$this, 'userRoleFilter'])
        ];        
    }
    
    /**
     * Translate and format the user status
     * 
     * @param string $status
     * 
     * @return string
     */
    public function formatUserStatusFilter(string $status): string
    {
        $class       = $this->getUserStatusClass($status);
        $translation = $this->getUserStatusTranslation($status);
        
        return '<span class="' . $class . '">' . $translation . '</span>';
    }
    
    /**
     * Translate the user role
     * 
     * @param string $role
     * 
     * @return string
     */
    public function userRoleFilter(string $role): string
    {
        switch($role) {
            case User::ROLE_USER:
                $translation = 'Gebruiker';
                break;
            case User::ROLE_ADMIN:
                $translation = 'Beheerder';
                break;
            case User::ROLE_SUPERADMIN:
                $translation = 'Superbeheerder';
                break;
            default:
                $translation = 'Onbekend';
                break;
        }
        
        return $translation;
    }
    
    /**
     * Get the translation of the user status
     * 
     * @param string $status
     * 
     * @return string
     */
    private function getUserStatusTranslation(string $status): string
    {
        switch($status) {
            case User::STATUS_ACTIVE:
                $translation = 'Actief';
                break;
            case User::STATUS_INACTIVE:
                $translation = 'Inactief';
                break;
            case User::STATUS_BLOCKED:
                $translation = 'Geblokkeerd';
                break;
            case User::STATUS_DELETED:
                $translation = 'Verwijderd';
                break;
            case User::STATUS_UNCONFIRMED:
                $translation = 'Niet bevestigd';
                break;
            default:
                $translation = 'Onbekend';
                break;
        }
        
        return $translation;
    }
    
    /**
     * Get the class of the user status
     * 
     * @param string $status
     * 
     * @return string
     */
    private function getUserStatusClass(string $status): string
    {
        switch($status) {
            case User::STATUS_ACTIVE:
                $class = 'badge badge-success';
                break;
            case User::STATUS_INACTIVE:
                $class = 'badge badge-danger';
                break;
            case User::STATUS_BLOCKED:
            case User::STATUS_UNCONFIRMED:
                $class = 'badge badge-warning';
                break;
            case User::STATUS_DELETED:
                $class = 'badge badge-dark';
                break;
            default:
                $class = 'badge badge-light';
                break;
        }
        
        return $class;
    }

}
