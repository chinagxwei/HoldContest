<?php

namespace App\Models\Member;

use App\Models\Admin\AdminNavigation;
use App\Models\Order\OrderIncomeConfig;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\WalletRelation;
use App\Models\Wallet\Wallet;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property string id
 * @property string wallet_id
 * @property int order_income_config_id
 * @property string mobile
 * @property string remark
 * @property int develop
 * @property int promotion_sn
 * @property string parent_id
 * @property string belong_agent_node
 * @property int register_type
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property MemberMessage[]|Collection readMessageLogs
 * @property OrderIncomeConfig incomeConfig
 * @property Wallet wallet
 * @property Member parent
 */
class Member extends Model
{
    use HasFactory, SoftDeletes, Uuids, SearchData, WalletRelation, CreatedRelation;

    protected $table = 'members';
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
        'wallet_id', 'order_income_config_id', 'mobile', 'remark',
        'develop', 'promotion_sn', 'parent_id', 'belong_agent_node',
        'register_type', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function readMessageLogs()
    {
        return $this->belongsToMany(
            MemberMessage::class,
            'member_message_logs',
            'member_message_id',
            'member_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function incomeConfig()
    {
        return $this->hasOne(OrderIncomeConfig::class, "id", "order_income_config_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, "id", "wallet_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(Member::class, "id", "parent_id");
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->wallet_id)) {
            $build = $build->where('wallet_id', $this->wallet_id);
        }

        if (!empty($this->promotion_sn)) {
            $build = $build->where('promotion_sn', 'like', "%{$this->promotion_sn}%");
        }

        if (!empty($this->mobile)) {
            $build = $build->where('mobile', 'like', "%{$this->mobile}%");
        }

        if (isset($this->develop)) {
            $build = $build->where('develop', $this->develop);
        }

        if (!empty($this->register_type)) {
            $build = $build->where('register_type', $this->register_type);
        }

        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
