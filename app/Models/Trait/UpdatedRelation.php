<?php

namespace App\Models\Trait;

use App\Models\User;

/**
 * @property int updated_by
 * @property User updater
 */
trait UpdatedRelation
{
    /**
     * @param $user_id
     * @return $this
     */
    public function setUpdatedBy($user_id = null)
    {
        if (empty($user_id) && empty($this->updated_by) && $user = auth('api')->user()) {
            $this->updated_by = $user->id;
        } else {
            if ($user_id != null) {
                $this->updated_by = $user_id;
            }
        }
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function updater()
    {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
