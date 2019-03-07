<?php
declare(strict_types = 1);

namespace App\AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\RequestStack;
Use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Build the menu
 *
 * @author Cindy Clijsters
 */
class MenuBuilder implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    
    private $factory;
    private $requestStack;
    private $translator;
    
    /**
     * Constructor function
     * 
     * @param FactoryInterface $factory
     */
    public function __construct(
        FactoryInterface $factory,
        RequestStack $requestStack,
        TranslatorInterface $translator
    ) {
        $this->factory      = $factory;
        $this->requestStack = $requestStack;
        $this->translator   = $translator;
    }
    
    /**
     * Build the main menu
     * 
     * @param array $options
     * 
     * @return type
     */
    public function mainMenu(array $options)
    {
        $menu = $this->factory->createItem('root', ['childrenAttributes' => ['class' => 'nav navbar-nav']]);
        
        // Add the dashboard item
        $menu
            ->addChild(
                'dashboard',
                [
                    'route' => 'rtAdminDashboard',
                    'label' => $this->translator->trans('Dashboard')
                ]
            )
            ->setExtra('icon', 'fa fa-dashboard');
        
        // Add the divider for my profile
        $menu
            ->addChild(
                'myProfileDivider',
                [
                    'label' => $this->translator->trans('My profile')
                ]
            );
        
        // Add the menu for my profile
        $menu
            -> addChild(
                'myProfile',
                [
                    'route' => 'rtAdminMyProfile',
                    'label' => $this->translator->trans('My profile')
                ]
            )
            ->setExtra('icon', 'fa fa-user');
            
        // Add the divider for my profile
        $menu
            ->addChild(
                'administrationDivider',
                [
                    'label' => $this->translator->trans('Administration')
                ]
            );
        
        // Add the menu for the users
        $menu
            ->addChild(
                'users',
                [
                    'route' => 'rtAdminUserOverview',
                    'label' => $this->translator->trans('Users')
                ]
            )
            ->setExtra('icon', 'fa fa-users');
        

        // Add the menu for the artists
        $menu
            ->addChild(
                'artists',
                [
                    'route' => 'rtAdminArtistOverview',
                    'label' => $this->translator->trans('Artists')
                ]
            )
            ->setExtra('icon', 'fa fa-microphone');
        
        // Add the menu for the albums
        $menu
            ->addChild(
                'albums',
                [
                    'route' => 'rtAdminAlbumOverview',
                    'label' => $this->translator->trans('Albums')
                ]
            )
            ->setExtra('icon', 'fa fa-music');
        
        // Add the divider for the extra's
        $menu
            ->addChild(
                'ExtraDivider',
                [
                    'label' => $this->translator->trans('Extra')
                ]
            );
        
        // Add the menu for the settings
        $menu
            ->addChild(
                'settings',
                [
                    'route' => 'rtAdminSettingsOverview',
                    'label' => $this->translator->trans('Settings')
                ]
            )
            ->setExtra('icon', 'fa fa-cog');
        
        // Set the correct menu item active
        $route = $this->requestStack->getCurrentRequest()->get('_route');
        
        if (preg_match("/rtAdminDashboard/i", $route)) {
            $menu->getChild('dashboard')->setCurrent(true);
        }
        
        if (preg_match("/rtAdminMyProfile/i", $route)) {
            $menu->getChild('myProfile')->setCurrent(true);
        }
        
        if (preg_match("/rtAdminUser/i", $route)) {
            $menu->getChild('users')->setCurrent(true);
        }        
        
        if (preg_match("/rtAdminAlbum/i", $route)) {
            $menu->getChild('albums')->setCurrent(true);
        }
        
        if (preg_match("/rtAdminArtist/i", $route)) {
            $menu->getChild('artists')->setCurrent(true);
        }
        
        if (preg_match("/rtAdminSettings/i", $route)) {
            $menu->getChild('settings')->setCurrent(true);
        }
        
        return $menu;
    }
    
}
