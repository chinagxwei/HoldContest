<?php

namespace App\Models\Trait;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongToSearchMemberData
{
    /**
     * @param $id
     * @param $member_id
     * @param array $with
     * @return Builder|Model|object|null|static
     */
    public static function findOneByMemberAndID($id, $member_id, $with = [])
    {
        return  self::query()->where('id', $id)->where('member_id', $member_id)->with($with)->first();
    }

    /**
     * @param $id
     * @param $member_id
     * @return Builder|Model|object|null|static
     */
    public static function findByMemberAndIDBuilder($id, $member_id)
    {
        return self::query()->where('id', $id)->where('member_id', $member_id);
    }

    /**
     * @param $member_id
     * @param array $with
     * @return Builder|Model|object|null|static
     */
    public static function findOneByMember($member_id, $with = [])
    {
        return self::query()->where('member_id', $member_id)->with($with)->first();
    }

    /**
     * @param $member_id
     * @return Builder|Model|object|null|static
     */
    public static function findByMemberBuilder($member_id)
    {
        return self::query()->where('member_id', $member_id);
    }
}
