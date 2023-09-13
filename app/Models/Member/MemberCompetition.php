<?php

namespace App\Models\Member;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string member_id
 * @property string game_room_id
 * @property string order_sn
 * @property int win
 * @property int ranking
 * @property int complete_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class MemberCompetition extends Pivot
{
    use HasFactory, SoftDeletes, CreatedRelation, OrderRelation, MemberRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_competition_logs';

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
        'member_id', 'order_sn', 'game_room_id',
        'win', 'ranking', 'complete_at',
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

        if (!empty($this->game_room_id)) {
            $build = $build->where('game_room_id', $this->game_room_id);
        }

        if (isset($this->win)) {
            $build = $build->where('win', $this->win);
        }

        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }

        if (!empty($param['complete_at']) && (count($param['complete_at']) === 2)) {
            $build = $build->whereBetween('complete_at', [$param['complete_at'][0], $param['complete_at'][1]]);
        }


        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
