<?php

namespace App\Models\Member;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string member_id
 * @property string order_sn
 * @property string prize_type
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class MemberPrizeLog extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, OrderRelation, MemberRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_prize_logs';

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
        'member_id', 'order_sn', 'prize_type',
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
        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }
        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }
        if (isset($this->prize_type)) {
            $build = $build->where('prize_type', $this->prize_type);
        }
        return $build->with($with)->orderBy('id', 'desc');
    }
}
