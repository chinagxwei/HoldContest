<?php

namespace App\Models\Wallet;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use App\Models\Trait\WalletRelation;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string wallet_id
 * @property string order_sn
 * @property string third_party_payment_sn
 * @property string third_party_merchant_id
 * @property int amount
 * @property string sign
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class WalletWithdrawal extends Model
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, WalletRelation, OrderRelation, SearchData, SignData;

    protected $table = 'wallet_withdrawals';
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
        'wallet_id', 'order_sn', 'third_party_payment_sn',
        'third_party_merchant_id', 'amount', 'sign',
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

        if (!empty($this->wallet_id)) {
            $build = $build->where('wallet_id', $this->wallet_id);
        }

        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }

        return $build->with($with)->orderBy('created_by', 'desc');
    }

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->wallet_id ?? 0,
            $this->order_sn ?? '',
            $this->third_party_payment_sn ?? '',
            $this->third_party_merchant_id ?? '',
            $this->amount ?? 0,
        ];

        $this->sign = sha1(join('_', $raw));
    }
}
