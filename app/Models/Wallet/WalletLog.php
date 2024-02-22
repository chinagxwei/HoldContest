<?php

namespace App\Models\Wallet;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use App\Models\Trait\UnitRelation;
use App\Models\Trait\WalletRelation;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string wallet_id
 * @property string order_sn
 * @property int amount
 * @property int surplus
 * @property int unit_id
 * @property int type
 * @property string sign
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class WalletLog extends BaseDataModel
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, OrderRelation, WalletRelation, UnitRelation, SearchData, SignData;

    protected $table = 'wallet_logs';

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
        'wallet_id', 'order_sn', 'amount', 'surplus', 'unit_id', 'type', 'sign', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    protected $casts = [
        'created_at' => 'timestamp',
    ];

    const FLOW_TYPE_OUTPUT = 1;

    const FLOW_TYPE_INPUT = 2;

    /**
     * @param $wallet_id
     * @param $order_sn
     * @param $amount
     * @param $surplus
     * @param $unit_id
     * @param $type
     * @return static|null
     * @throws \Exception
     */
    public static function generate($wallet_id, $order_sn, $amount, $surplus, $unit_id, $type)
    {
        $model = new static();
        $model->wallet_id = $wallet_id;
        $model->order_sn = $order_sn;
        $model->type = $type;
        $model->unit_id = $unit_id;
        $model->surplus = abs($surplus);
        if ($type === self::FLOW_TYPE_OUTPUT) {
            $model->amount = -(abs($amount));
        } elseif ($type === self::FLOW_TYPE_INPUT) {
            $model->amount = abs($amount);
        } else {
            throw new \Exception('钱包日志类型错误');
        }
        $model->setSign();
        return $model->save() ? $model : null;
    }

    /**
     * @param $wallet_id
     * @param $order_sn
     * @param $amount
     * @param $surplus
     * @param $unit_id
     * @return static|null
     * @throws \Exception
     */
    public static function input($wallet_id, $order_sn, $amount, $surplus, $unit_id)
    {
        return self::generate($wallet_id, $order_sn, $amount, $surplus, $unit_id, self::FLOW_TYPE_INPUT);
    }

    /**
     * @param $wallet_id
     * @param $order_sn
     * @param $amount
     * @param $surplus
     * @param $unit_id
     * @return static|null
     * @throws \Exception
     */
    public static function output($wallet_id, $order_sn, $amount, $surplus, $unit_id)
    {
        return self::generate($wallet_id, $order_sn, $amount, $surplus, $unit_id, self::FLOW_TYPE_OUTPUT);
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;

        if (!empty($this->wallet_id)) {
            $build = $build->where('wallet_id', $this->wallet_id);
        }
        if (!empty($this->wallet_recharge_id)) {
            $build = $build->where('wallet_recharge_id', $this->wallet_recharge_id);
        }

        if (isset($this->type)) {
            $build = $build->where('type', $this->type);
        }

        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }

        return $build->with($with)->orderBy('created_at', 'desc');

    }

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->wallet_id ?? 0,
            $this->order_sn ?? '',
            $this->amount ?? 0,
            $this->surplus ?? 0,
            $this->type ?? 0,
        ];

        $this->sign = sha1(join('_', $raw));
    }
}
