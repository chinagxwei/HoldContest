<?php

namespace App\Models\Trait;

use App\Models\Admin\AdminRole;

/**
 * @property int role_id
 * @property AdminRole adminRole
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
        return $this->hasOne(AdminRole::class, 'id', 'role_id');
    }
}
