<?php

namespace App\Models\Order;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\GoodsRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\OrderRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string order_sn
 * @property string member_id
 * @property string goods_id
 * @property int purchase_volume
 * @property string remark
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class OrderCart extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, MemberRelation, OrderRelation, GoodsRelation;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'order_carts';

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
        'order_sn', 'member_id', 'goods_id', 'purchase_volume',
        'remark', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

}
