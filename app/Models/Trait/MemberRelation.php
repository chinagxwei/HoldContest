<?php

namespace App\Models\Trait;

use App\Models\Member\Member;

/**
 * @property int member_id
 * @property Member member
 */
trait MemberRelation
{
    public function setMember($member_id)
    {
        $this->member_id = $member_id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }
}
