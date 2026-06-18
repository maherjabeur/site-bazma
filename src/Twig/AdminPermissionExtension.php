<?php

namespace App\Twig;

use App\Security\AdminPermissionCatalog;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AdminPermissionExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('admin_permission_label', $this->permissionLabel(...)),
        ];
    }

    public function permissionLabel(string $role): string
    {
        return AdminPermissionCatalog::label($role);
    }
}
