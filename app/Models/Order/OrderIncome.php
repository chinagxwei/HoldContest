<?php

namespace App\Models\Order;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property String id
 * @property int member_id
 * @property string from_order_sn
 * @property string to_order_sn
 * @property int amount
 * @property string sign
 * @property int created_by
 * @property int updated_by
 * @property Order formOrder
 * @property Order toOrder
 */
class OrderIncome extends Model
{
    use HasFactory, SoftDeletes, MemberRelation, CreatedRelation, SearchData, SignData;

    protected $table = 'order_income';
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
        'member_id', 'from_order_sn', 'to_order_sn',
        'amount', 'sign', 'created_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function formOrder()
    {
        return $this->hasOne(Order::class, 'sn', 'from_order_sn');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function toOrder()
    {
        return $this->hasOne(Order::class, 'sn', 'to_order_sn');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->franchisee_id)) {
            $build = $build->where('franchisee_id', $this->franchisee_id);
        }
        if (!empty($this->from_order_sn)) {
            $build = $build->where('from_order_sn', 'like', "%{$this->from_order_sn}%");
        }
        if (!empty($this->to_order_sn)) {
            $build = $build->where('to_order_sn', 'like', "%{$this->to_order_sn}%");
        }
        if (!empty($param['created_at']) && count($param['created_at']) === 2) {
            $build = $build->whereBetween('created_at', [$param['created_at'][0], $param['created_at'][1]]);
        }
        return $build->with($with)->orderBy('id', 'desc');
    }

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->member_id ?? '',
            $this->from_order_sn ?? '',
            $this->to_order_sn ?? 0,
            $this->amount ?? 0,
        ];

        $this->sign = sha1(join('_', $raw));
    }
}
