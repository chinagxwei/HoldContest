<?php

namespace App\Models\Wallet;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use App\Models\Trait\UnitRelation;
use App\Models\Trait\WalletRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string order_sn
 * @property string wallet_id
 * @property int denomination
 * @property int balance
 * @property int unit_id
 * @property int frozen
 * @property int channel
 * @property int gift
 * @property string sign
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class WalletRecharge extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, UnitRelation, OrderRelation, WalletRelation, SignData, SearchData;

    protected $table = 'wallet_recharges';
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
        'wallet_id', 'order_sn', 'denomination',
        'balance', 'unit_id', 'frozen',
        'channel', 'gift', 'sign',
        'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->wallet_id ?? 0,
            $this->order_sn ?? '',
            $this->denomination ?? 0,
            $this->unit_id ?? 0,
            $this->channel ?? 0,
            $this->gift ?? 1,
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
        if (!empty($this->unit_id)) {
            $build = $build->where('unit_id', $this->unit_id);
        }

        if (isset($this->gift)) {
            $build = $build->where('gift', $this->gift);
        }

        if (isset($this->channel)) {
            $build = $build->where('channel', $this->channel);
        }

        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
