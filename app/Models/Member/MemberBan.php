<?php

namespace App\Models\Member;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string member_id
 * @property int started_at
 * @property int ended_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class MemberBan extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, MemberRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_bans';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'U';

    protected $fillable = [
        'member_id', 'started_at', 'ended_at',
        'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }

        if (!empty($param['started_at']) && (count($param['started_at']) === 2)) {
            $build = $build->whereBetween('started_at', [$param['started_at'][0], $param['started_at'][1]]);
        }

        if (!empty($param['ended_at']) && (count($param['ended_at']) === 2)) {
            $build = $build->whereBetween('ended_at', [$param['ended_at'][0], $param['ended_at'][1]]);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
