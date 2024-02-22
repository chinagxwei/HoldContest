<?php

namespace App\Models\Wallet;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use App\Models\Trait\WalletRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string order_sn
 * @property string wallet_id
 * @property string wallet_recharge_id
 * @property string member_id
 * @property int amount
 * @property int status
 * @property string sign
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property WalletRecharge walletRecharge
 */
class WalletConsume extends BaseDataModel
{
    use HasFactory, SoftDeletes, MemberRelation, CreatedRelation, OrderRelation, WalletRelation, SignData, SearchData;

    protected $table = 'wallet_consumes';
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
        'order_sn', 'wallet_id', 'wallet_recharge_id',
        'member_id', 'amount', 'status', 'sign', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    public function setWalletRecharge($wallet_recharge_id)
    {
        $this->wallet_recharge_id = $wallet_recharge_id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function walletRecharge()
    {
        return $this->hasOne(WalletRecharge::class, 'id', 'wallet_recharge_id');
    }

    /**
     * @return $this
     */
    public function setDisable()
    {
        $this->status = self::DISABLE;
        return $this;
    }

    /**
     * @return $this
     */
    public function rollback()
    {
        $this->walletRecharge()->increment('balance', $this->amount);

        $this->setDisable()->setSign();

        return $this;
    }

    /**
     * @param $wallet_id
     * @param $wallet_recharge_id
     * @param $order_sn
     * @param $member_id
     * @param $amount
     * @return static|null
     */
    public static function generate($wallet_id, $wallet_recharge_id, $order_sn, $member_id, $amount)
    {
        $model = new static();
        $model->wallet_id = $wallet_id;
        $model->wallet_recharge_id = $wallet_recharge_id;
        $model->order_sn = $order_sn;
        $model->member_id = $member_id;
        $model->amount = $amount;
        $model->status = self::ENABLE;
        $model->setSign();
        return $model->save() ? $model : null;
    }

    /**
     * @param $order_sn
     * @param bool $lock
     * @param array $with
     * @return Builder[]|Collection|static[]
     */
    public static function findAllByOrderSN($order_sn, $lock = false, $with = [])
    {
        return self::findByOrderSNBuild($order_sn)
            ->where('status', self::ENABLE)
            ->lock($lock)
            ->with($with)
            ->get();
    }

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->order_sn ?? '',
            $this->wallet_id ?? 0,
            $this->wallet_recharge_id ?? 0,
            $this->member_id ?? '',
            $this->amount ?? 0,
            $this->status ?? 0,
        ];

        $this->sign = sha1(join('_', $raw));
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

        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }

        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
