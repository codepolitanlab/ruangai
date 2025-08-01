<?php

namespace Heroicadmin\Cells;

class SidebarMenuCell
{
    public $menu;

    // Show sidebar admin menu
    public function show($params = [])
    {
        $config     = config('Heroicadmin');
        $menu       = $config->sidebarMenu;
        $scope      = '/' . $config->urlScope;
        $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');

        return $this->renderMenu($menu, $params['module'], $params['submodule'], $scope, $currentUrl);
    }

    private function renderMenu($menu, $currentModule, $currentSubmodule, $scope = '/admin', $currentUrl = '/')
    {
        $menuHTML = '<div class="sidebar-menu">';
        $menuHTML .= '<ul class="menu">';

        foreach ($menu as $key => $item) {
            $hasChildren    = isset($item['children']) && is_array($item['children']);
            $isParentActive = $currentModule === ($item['module'] ?? '');

            // Place scope at the start only if URL is set without /
            $itemUrl = strpos($item['url'], '/') === 0 ? site_url($item['url']) : $scope . '/' . $item['url'];

            $parentClasses = ['sidebar-item'];
            if ($hasChildren) {
                $parentClasses[] = 'has-sub';
            }

            if ($isParentActive) {
                $parentClasses[] = 'active submenu-open';
            }

            $menuHTML .= '<li class="' . implode(' ', $parentClasses) . '">';
            $menuHTML .= '<a href="' . htmlspecialchars($itemUrl) . '" class="sidebar-link">';
            $menuHTML .= '<i class="' . htmlspecialchars($item['icon']) . '"></i>';
            $menuHTML .= '<span>' . htmlspecialchars($item['label']) . '</span>';
            $menuHTML .= '</a>';

            if ($hasChildren) {
                $menuHTML .= '<ul class="submenu">';

                foreach ($item['children'] as $subKey => $subItem) {
                    $subItemUrl = strpos($subItem['url'], '/') === 0 ? site_url($subItem['url']) : $scope . '/' . $subItem['url'];

                    $isSubmenuActive = $currentSubmodule === ($subItem['submodule'] ?? '');
                    $submenuClasses  = ['submenu-item'];
                    if ($isSubmenuActive) {
                        $submenuClasses[] = 'active';
                    }

                    $menuHTML .= '<li class="' . implode(' ', $submenuClasses) . '">';
                    $menuHTML .= '<a href="' . htmlspecialchars($subItemUrl) . '" class="submenu-link">';
                    $menuHTML .= '<i class="' . htmlspecialchars($subItem['icon']) . '"></i>';
                    $menuHTML .= '<span>' . htmlspecialchars($subItem['label']) . '</span>';
                    $menuHTML .= '</a>';
                    $menuHTML .= '</li>';
                }
                $menuHTML .= '</ul>';
            }

            $menuHTML .= '</li>';
        }

        $menuHTML .= '</ul>';
        $menuHTML .= '</div>';

        return $menuHTML;
    }
}
