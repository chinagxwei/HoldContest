<?php

namespace App\Models\Order;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use App\Models\Trait\UnitRelation;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Ramsey\Uuid\Uuid;

/**
 * @property string id
 * @property string sn
 * @property string third_party_payment_sn
 * @property string third_party_merchant_id
 * @property int order_category
 * @property string member_id
 * @property int pay_method
 * @property int unit_id
 * @property int pay_at
 * @property int pay_status
 * @property int total_amount
 * @property int reduce_amount
 * @property int pay_amount
 * @property int commission_amount
 * @property int real_income_amount
 * @property int cancel_at
 * @property string sign
 * @property string remark
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property OrderCart carts
 */
class Order extends BaseDataModel
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, MemberRelation, UnitRelation, SearchData, SignData;

    protected $table = 'orders';

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
        'sn', 'third_party_payment_sn', 'third_party_merchant_id',
        'member_id', 'order_category', 'unit_id', 'pay_method',
        'pay_at', 'pay_status', 'total_amount', 'reduce_amount',
        'pay_amount', 'commission_amount', 'real_income_amount',
        'cancel_at', 'sign', 'remark', 'created_by', 'updated_by',
        'created_at'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    const ORDER_CATEGORY_RECHARGE = 1;

    const ORDER_CATEGORY_VIP = 2;

    const ORDER_CATEGORY_WITHDRAWAL = 3;

    const ORDER_CATEGORY_CONSUME = 4;

    const ORDER_CATEGORY_INCOME = 5;

    const PAY_METHOD_PLATFORM = 1;

    const PAY_METHOD_ALIPAY = 2;

    const PAY_METHOD_WECHAT = 3;

    const PAY_METHOD_WALLET = 4;

    const PAY_STATUS_CANCEL = -1;

    const PAY_STATUS_UN_PAY = 0;

    const PAY_STATUS_PAYING = 1;

    const PAY_STATUS_PAYED = 2;

    public function __construct()
    {
        static::creating(function ($model) {
            if (empty($model->sn)) {
                $model->sn = date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
            }
        });
    }

    /**
     * @return bool
     */
    public function isCancel(){
        return $this->cancel_at > 0 && $this->pay_status === -1;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function carts()
    {
        return $this->hasMany(OrderCart::class, 'order_sn', 'sn');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }
        if (!empty($this->sn)) {
            $build = $build->where('sn', 'like', "%{$this->sn}%");
        }
        if (isset($this->pay_method)) {
            $build = $build->where('pay_method', $this->pay_method);
        }
        if (isset($this->pay_status)) {
            $build = $build->where('pay_status', $this->pay_status);
        }
        if (isset($this->order_category)) {
            $build = $build->where('order_category', $this->order_category);
        }
        if (!empty($param['pay_at']) && (count($param['pay_at']) === 2)) {
            $build = $build->whereBetween('pay_at', [$param['pay_at'][0], $param['pay_at'][1]]);
        }
        if (!empty($param['cancel_at']) && (count($param['cancel_at']) === 2)) {
            $build = $build->whereBetween('cancel_at', [$param['cancel_at'][0], $param['cancel_at'][1]]);
        }
        if (!empty($param['created_at']) && (count($param['created_at']) === 2)) {
            $build = $build->whereBetween('created_at', [$param['created_at'][0], $param['created_at'][1]]);
        }

        return $build->with($with)->orderBy('created_at', 'desc');
    }

    /**
     * @param $total_amount
     * @param $pay_amount
     * @param $commission_amount
     * @return $this
     */
    public function setAmount($total_amount, $pay_amount, $commission_amount = 0)
    {
        $this->total_amount = $total_amount;
        $this->pay_amount = $pay_amount;
        $this->reduce_amount = $total_amount - $pay_amount;
        $this->commission_amount = $commission_amount;
        $this->real_income_amount = $pay_amount - $commission_amount;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCancel()
    {
        $this->pay_status = self::PAY_STATUS_CANCEL;
        $this->cancel_at = time();
        return $this;
    }

    /**
     * @return $this
     */
    public function complete($pay_method = null)
    {
        if (!empty($pay_method)){
            $this->pay_method = $pay_method ;
        }
        $this->pay_status = self::PAY_STATUS_PAYED;
        $this->pay_at = time();
        return $this;
    }

    /**
     * @param $order_category
     * @param $member_id
     * @param $total_amount
     * @param $pay_amount
     * @param $unit_id
     * @param $pay_method
     * @param $pay_at
     * @param $pay_status
     * @param $remark
     * @return static
     */
    public static function simpleOrder($order_category, $member_id, $total_amount, $pay_amount, $unit_id, $pay_method, $pay_at, $pay_status, $remark)
    {
        $order = new static();
        $order->id = Uuid::uuid4()->toString();
        $order->order_category = $order_category;
        $order->member_id = $member_id;
        $order->total_amount = $total_amount;
        $order->pay_amount = $pay_amount;
        $order->reduce_amount = $total_amount - $pay_amount;
        $order->pay_method = $pay_method;
        $order->unit_id = $unit_id;
        $order->pay_at = $pay_at;
        $order->pay_status = $pay_status;
        $order->remark = $remark;
        return $order;
    }

    /**
     * @param $member_id
     * @param $total_amount
     * @param $pay_amount
     * @param $unit_id
     * @param $remark
     * @param $pay_method
     * @param $pay_at
     * @param $pay_status
     * @return static
     */
    public static function getRechargeOrder($member_id, $total_amount, $pay_amount, $unit_id, $remark = '', $pay_method = self::PAY_METHOD_PLATFORM, $pay_at = 0, $pay_status = self::PAY_STATUS_UN_PAY)
    {
        return self::simpleOrder(self::ORDER_CATEGORY_RECHARGE, $member_id, $total_amount, $pay_amount, $unit_id, $pay_method, $pay_at, $pay_status, $remark);
    }

    /**
     * @param $member_id
     * @param $total_amount
     * @param $pay_amount
     * @param $unit_id
     * @param $remark
     * @param $pay_method
     * @param $pay_at
     * @param $pay_status
     * @return static
     */
    public static function getVipOrder($member_id, $total_amount, $pay_amount, $unit_id, $remark = '', $pay_method = self::PAY_METHOD_PLATFORM, $pay_at = 0, $pay_status = self::PAY_STATUS_UN_PAY)
    {
        return self::simpleOrder(self::ORDER_CATEGORY_VIP, $member_id, $total_amount, $pay_amount, $unit_id, $pay_method, $pay_at, $pay_status, $remark);
    }

    /**
     * @param $member_id
     * @param $total_amount
     * @param $unit_id
     * @param $remark
     * @return static
     */
    public static function getWithdrawalOrder($member_id, $total_amount, $unit_id, $remark = '')
    {
        return self::simpleOrder(self::ORDER_CATEGORY_WITHDRAWAL, $member_id, $total_amount, $total_amount, $unit_id, self::PAY_METHOD_WALLET, time(), self::PAY_STATUS_PAYED, $remark);
    }

    /**
     * @param $member_id
     * @param $total_amount
     * @param $pay_amount
     * @param $unit_id
     * @param $remark
     * @param $pay_method
     * @param $pay_at
     * @param $pay_status
     * @return static
     */
    public static function getCompetitionOrder($member_id, $total_amount, $pay_amount, $unit_id, $remark = '', $pay_method = self::PAY_METHOD_WALLET, $pay_at = 0, $pay_status = self::PAY_STATUS_UN_PAY)
    {
        return self::simpleOrder(self::ORDER_CATEGORY_CONSUME, $member_id, $total_amount, $pay_amount, $unit_id, $pay_method, $pay_at, $pay_status, $remark);
    }

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->third_party_payment_sn ?? '',
            $this->third_party_merchant_id ?? '',
            $this->order_category ?? '',
            $this->member_id ?? '',
            $this->pay_method ?? '',
            $this->unit_id ?? 0,
            $this->pay_at ?? 0,
            $this->pay_status ?? 0,
            $this->total_amount ?? 0,
            $this->reduce_amount ?? 0,
            $this->pay_amount ?? 0,
            $this->commission_amount ?? 0,
            $this->real_income_amount ?? 0,
            $this->cancel_at ?? 0,
        ];

        $this->sign = sha1(join('_', $raw));
    }
}
