<?php

namespace App\Models\Member;

use App\Models\Admin\AdminNavigation;
use App\Models\Competition\CompetitionGame;
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
use Ramsey\Uuid\Uuid;

/**
 * @property string id
 * @property string wallet_id
 * @property int order_income_config_id
 * @property string mobile
 * @property string nickname
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
 * @property MemberAddress addresses
 * @property MemberBan banInfo
 * @property MemberVIP vipInfo
 * @property MemberGameAccount[]|Collection gameAccounts
 * @property CompetitionGame[]|Collection games
 * @property MemberCompetition memberCompetition
 */
class Member extends Model
{
    use HasFactory, SoftDeletes, Uuids, SearchData, WalletRelation, CreatedRelation;

    protected $table = 'members';

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
        'wallet_id', 'order_income_config_id', 'mobile', 'remark',
        'develop', 'promotion_sn', 'parent_id', 'belong_agent_node',
        'register_type', 'created_by', 'updated_by', 'nickname'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

//    public function __construct()
//    {
//        static::creating(function ($model) {
//            if (empty($model->promotion_sn)) {
//                $model->promotion_sn = md5(date('YmdHis') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8));
//            }
//        });
//    }

    /**
     * @return bool
     */
    public function isBlock()
    {
        return !empty($this->banInfo);
    }

    /**
     * @return string
     */
    public function getCurrentRoomKey(){
        return "join_room_{$this->id}";
    }

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(
            Member::class,
            'member_agents',
            'parent_id',
            'child_id'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(MemberAddress::class, "member_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function banInfo()
    {
        return $this->hasOne(MemberBan::class, "member_id", "id")
            ->where('started_at', '<', time())
            ->where('ended_at', '>', time());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function vipInfo()
    {
        return $this->hasOne(MemberVIP::class, "member_id", "id")
            ->where('started_at', '<=', time())
            ->where('ended_at', '>=', time());
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gameAccounts()
    {
        return $this->hasMany(MemberGameAccount::class, "member_id", "id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function games()
    {
        return $this->belongsToMany(
            CompetitionGame::class,
            "member_game_accounts",
            "member_id",
            "game_id"
        )->as('game_account')->withPivot(['account_type', 'nickname', 'game_code']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function memberCompetition()
    {
        return $this->hasOne(MemberCompetition::class, "member_id", "id")
            ->whereHas('room', function ($query) {
                $query->where('started_at', '>', time());
            });
    }

    /**
     * @param $unit_id
     * @return mixed|null
     */
    public function getUnitBalanceAccount($unit_id)
    {
        return $this->wallet->accounts()
            ->where('unit_id', $unit_id)
            ->first();
    }


    /**
     * @param $user_id
     * @param $with
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null|static
     */
    public static function findOneByUser($user_id, $with = [])
    {
        return self::query()->where('created_by', $user_id)->with($with)->first();
    }

    /**
     * @param $mobile
     * @param $with
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null|static
     */
    public static function findOneByMobile($mobile, $with = [])
    {
        return self::query()->where('mobile', $mobile)->with($with)->first();
    }

    /**
     * @param $mobile
     * @param $username
     * @return bool
     */
    public static function checkRegister($mobile, $username)
    {
        return self::query()->orWhere('mobile', $mobile)
            ->orWhereHas('creator',function ($query) use ($username) {
                $query->where('username', $username);
            })->exists();
    }

    /**
     * @param $promotion_sn
     * @param $with
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null|static
     */
    public static function findOneByPromotion($promotion_sn, $with = [])
    {
        return self::query()->where('promotion_sn', $promotion_sn)->with($with)->first();
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

        if (!empty($this->nickname)) {
            $build = $build->where('nickname', 'like', "%{$this->nickname}%");
        }

        if (!empty($this->mobile)) {
            $build = $build->where('mobile', 'like', "%{$this->mobile}%");
        }

        if (isset($this->develop)) {
            $build = $build->where('develop', $this->develop);
        }

        if (isset($this->register_type)) {
            $build = $build->where('register_type', $this->register_type);
        }

        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
