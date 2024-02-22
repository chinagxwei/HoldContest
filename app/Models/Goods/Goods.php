<?php

namespace App\Models\Goods;

use App\Models\BaseDataModel;
use App\Models\Competition\CompetitionRoomLink;
use App\Models\System\Unit;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property string id
 * @property string title
 * @property string description
 * @property int goods_type
 * @property int relation_category
 * @property int relation_id
 * @property int stock
 * @property int status
 * @property int bind
 * @property int started_at
 * @property int ended_at
 * @property int sort
 * @property string remark
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property ProductVIP vip
 * @property ProductRecharge recharge
 */
class Goods extends BaseDataModel
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SearchData;

    protected $table = 'goods';

    protected $keyType = 'string';
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
        'title', 'description', 'stock',
        'status', 'bind', 'started_at',
        'ended_at', 'sort', 'remark',
        'remark', 'created_by', 'updated_by',
        'goods_type', 'relation_category', 'relation_id'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    const GOODS_NORMAL = 1;
    const GOODS_RELATION = 2;
    const GOODS_TREE = 3;

    const CATEGORY_VIP = 1;

    const CATEGORY_RECHARGE_CARD = 2;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function prices()
    {
        return $this->belongsToMany(
            Unit::class,
            'goods_prices',
            'unit_id',
            'goods_id'
        );
    }

    /**
     * @return bool
     */
    public function isRelationType(){
        return $this->goods_type === self::GOODS_RELATION;
    }

    /**
     * @return bool
     */
    public function isRechargeCardCategory(){
        return $this->relation_category === self::CATEGORY_RECHARGE_CARD;
    }

    /**
     * @return bool
     */
    public function isVipCategory(){
        return $this->relation_category === self::CATEGORY_VIP;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vip()
    {
        return $this->hasOne(ProductVIP::class, 'id', 'relation_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function recharge()
    {
        return $this->hasOne(ProductRecharge::class, 'id', 'relation_id');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (isset($this->title)) {
            $build = $build->where('title', $this->title);
        }
        if (isset($this->description)) {
            $build = $build->where('description', $this->description);
        }

        if (isset($this->status)) {
            $build = $build->where('status', $this->status);
        }

        if (isset($this->bind)) {
            $build = $build->where('bind', $this->bind);
        }

        if (isset($this->goods_type)) {
            $build = $build->where('goods_type', $this->goods_type);
        }

        if (isset($this->relation_category)) {
            $build = $build->where('relation_category', $this->relation_category);
        }

        if (isset($this->relation_id)) {
            $build = $build->where('relation_id', $this->relation_id);
        }

        if (!empty($param['started_at']) && (count($param['started_at']) === 2)) {
            $build = $build->whereBetween('started_at', [$param['started_at'][0], $param['started_at'][1]]);
        }

        if (!empty($param['ended_at']) && (count($param['ended_at']) === 2)) {
            $build = $build->whereBetween('ended_at', [$param['ended_at'][0], $param['ended_at'][1]]);
        }

        return $build->with($with);
    }
}
