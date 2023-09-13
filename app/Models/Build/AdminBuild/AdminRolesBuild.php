<?php

namespace App\Models\Build\AdminBuild;

trait AdminRolesBuild
{
    public function setRoleName(string $role_name): void
    {
        $this->role_name = $role_name;
    }
}
