<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class NavbarCell extends Cell
{
    public function render(): string
    {
        $links = $this->getNavigationLinks();
        $filteredLinks = $this->filterLinksByPermission($links);

        return $this->view('navbar', ['links' => $filteredLinks]);
    }

    private function getNavigationLinks()
    {
        $db = db_connect();
        return $db->table('navigation_links')->get()->getResult();
    }

    private function filterLinksByPermission($links)
    {
        $user = auth()->user();
        $filteredLinks = [];

        foreach ($links as $link) {
            if (empty($link->permission_key) || ($user && $user->can($link->permission_key))) {
                $filteredLinks[] = $link;
            }
        }

        return $filteredLinks;
    }
}
