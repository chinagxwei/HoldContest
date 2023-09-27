<?php

namespace App\Models\Order;

use App\Models\Trait\CreatedBySet;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\FranchiseeRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property double vip_commission
 * @property double recharge_commission
 * @property double consume_commission
 * @property double level_1_play_commission
 * @property double level_2_play_commission
 * @property double agent_commission
 * @property double withdraw_point
 * @property double vip_withdraw_point
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class OrderIncomeConfig extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    protected $table = 'order_income_configs';
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
        'title', 'vip_commission', 'recharge_commission',
        'consume_commission', 'level_1_play_commission', 'level_2_play_commission',
        'agent_commission', 'withdraw_point', 'vip_withdraw_point', 'created_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->title)) {
            $build = $build->where('title', 'like', "%{$this->title}%");
        }
        return $build->with($with)->orderBy('id', 'desc');
    }
}
