<?php

namespace App\Models\Trait;

use App\Models\User;

/**
 * @property int created_by
 * @property User user
 */
trait CreatedBySet
{
    /**
     * @param $user_id
     * @return $this
     */
    public function setCreatedBy($user_id = null)
    {
        if (empty($user_id) && empty($this->created_by) && $user = auth('api')->user()) {
            $this->created_by = $user->id;
        } else {
            if ($user_id != null) {
                $this->created_by = $user_id;
            }
        }
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
