<?php

namespace App\Models\Member;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string member_id
 * @property int quest_id
 * @property int progress
 * @property int complete
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class MemberQuest extends Pivot
{
    use HasFactory, SoftDeletes, CreatedRelation, MemberRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_quest_logs';

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
        'member_id', 'quest_id', 'progress',
        'complete', 'created_by', 'updated_by'
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

        if (!empty($this->quest_id)) {
            $build = $build->where('quest_id', $this->quest_id);
        }

        if (isset($this->complete)) {
            $build = $build->where('complete', $this->complete);
        }


        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
