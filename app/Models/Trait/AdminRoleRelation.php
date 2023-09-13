<?php

namespace App\Models\Trait;

use App\Models\Admin\AdminRoles;

/**
 * @property int role_id
 * @property AdminRoles adminRole
 */
trait AdminRoleRelation
{
    public function setAdminRole($role_id){
        $this->role_id = $role_id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function adminRole()
    {
        return $this->hasOne(AdminRoles::class, 'id', 'role_id');
    }
}
