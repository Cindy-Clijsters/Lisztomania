<?php
declare(strict_types = 1);

namespace App\AppBundle\Twig;

use Twig\Extension\AbstractExtension;
use Symfony\Contracts\Translation\TranslatorInterface;

use App\Entity\User;

/**
 * Holds twig extensions for the users
 * 
 * @author Cindy Clijsters
 */
class UserExtension extends AbstractExtension
{
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }    
    
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
        $translation = $this->translator->trans('status.' . $status, [], 'users');
        
        return '<span class="' . $class . '">' . $translation . '</span>';
    }
    
    /**
     * Translate the user role
     * 
     * @param array $roles
     * 
     * @return string
     */
    public function userRoleFilter(array $roles): string
    {
        $role        = implode($roles, ',');
        $translation = $this->translator->trans('role.' . $role, [], 'users');
        
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
