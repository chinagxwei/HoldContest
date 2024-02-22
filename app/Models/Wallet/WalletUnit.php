<?php

namespace App\Models\Wallet;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string member_id
 * @property int title_id
 * @property int total_balance
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class WalletUnit extends Pivot
{
    use HasFactory;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'wallet_unit_balance';

    /**
     * 指定是否模型应该被戳记时间。
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 模型日期列的存储格式
     *
     * @var string
     */
    protected $dateFormat = 'U';

    protected $fillable = [
        'wallet_id', 'unit_id', 'total_balance',
        'sign'
    ];

    /**
     * @param $wallet_id
     * @param $unit_id
     * @return bool
     */
    public static function hasRow($wallet_id, $unit_id)
    {
        return self::query()->where('wallet_id', $wallet_id)->where('unit_id', $unit_id)->exists();
    }

    /**
     * @param $wallet_id
     * @param $unit_id
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public static function findOne($wallet_id, $unit_id){
        return self::query()->where('wallet_id', $wallet_id)->where('unit_id', $unit_id)->first();
    }
}
