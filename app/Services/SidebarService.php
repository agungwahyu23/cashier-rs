<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class SidebarService
{
    /**
     * Get filtered menu items based on user roles
     * 
     * @return Collection
     */
    public static function getMenu(): Collection
    {
        $menuItems = config('sidebar.menu');
        $user = Auth::user();

        return collect($menuItems)->filter(function ($item) use ($user) {
            // Skip if type is header and no roles match
            if (isset($item['type']) && $item['type'] === 'header') {
                return static::hasAccess($item, $user);
            }

            // Include if user has access
            if (!isset($item['submenu'])) {
                return static::hasAccess($item, $user);
            }

            // For items with submenu, include if user has access to any submenu item
            if (isset($item['submenu']) && is_array($item['submenu'])) {
                $visibleSubmenu = collect($item['submenu'])->filter(
                    fn($subitem) => static::hasAccess($subitem, $user)
                );
                
                return $visibleSubmenu->count() > 0;
            }

            return static::hasAccess($item, $user);
        })->values();
    }

    /**
     * Get filtered submenu items
     * 
     * @param array $item
     * @return Collection
     */
    public static function getSubmenu(array $item): Collection
    {
        $user = Auth::user();

        if (!isset($item['submenu']) || !is_array($item['submenu'])) {
            return collect();
        }

        return collect($item['submenu'])->filter(function ($subitem) use ($user) {
            return static::hasAccess($subitem, $user);
        })->values();
    }

    /**
     * Check if user has access to menu item
     * 
     * @param array $item
     * @param $user
     * @return bool
     */
    private static function hasAccess(array $item, $user): bool
    {
        // If no roles specified, show to everyone
        if (!isset($item['roles']) || empty($item['roles'])) {
            return true;
        }

        // If user not authenticated, deny access
        if (!$user) {
            return false;
        }

        // Check if user has any of the required roles
        return $user->hasAnyRole($item['roles']);
    }

    /**
     * Get URL for menu item
     * 
     * @param array $item
     * @return string|null
     */
    public static function getUrl(array $item): ?string
    {
        if (isset($item['route'])) {
            return route($item['route']);
        }

        if (isset($item['href'])) {
            return $item['href'];
        }

        return null;
    }

    /**
     * Check if current route matches menu item
     * 
     * @param array $item
     * @return bool
     */
    public static function isActive(array $item): bool
    {
        if (isset($item['routeIsActive'])) {
            return request()->routeIs($item['routeIsActive'] . '*');
        }

        return false;
    }
}
