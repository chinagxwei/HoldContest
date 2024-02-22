<?php

namespace App\Models\Member;

use App\Models\BaseDataModel;
use App\Models\Competition\CompetitionRoom;
use App\Models\Order\Order;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\OrderRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string from_order_sn
 * @property string member_id
 * @property string game_room_id
 * @property string order_sn
 * @property int win
 * @property int ranking
 * @property int team_index
 * @property int complete_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property CompetitionRoom room
 * @property Member member
 * @property Order fromOrder
 */
class MemberCompetition extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, OrderRelation, MemberRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_competition_logs';

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
        'member_id', 'from_order_sn', 'order_sn', 'game_room_id',
        'win', 'ranking', 'team_index', 'complete_at',
        'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function room()
    {
        return $this->hasOne(CompetitionRoom::class, 'id', 'game_room_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function member()
    {
        return $this->hasOne(Member::class, 'id', 'member_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fromOrder()
    {
        return $this->hasOne(Order::class, 'sn', 'from_order_sn');
    }

    /**
     * @param $win
     * @param $order_sn
     * @return $this
     */
    public function setWin($win, $order_sn = null)
    {
        $this->win = $win;
        $this->order_sn = $order_sn;
        $this->complete_at = time();
        return $this;
    }

    /**
     * @param $game_room_id
     * @param array $with
     * @return Builder|Model|object|null|static
     */
    public static function getEntryQuota($game_room_id, $with = [])
    {
        return self::query()
            ->where('game_room_id', $game_room_id)
            ->whereNull('member_id')
            ->orderBy('team_index')
            ->with($with)
            ->lock()
            ->first();
    }

    /**
     * 剩余位置
     * @param $game_room_id
     * @return int
     */
    public static function lastCount($game_room_id)
    {
        return self::query()
            ->where('game_room_id', $game_room_id)
            ->whereNull('member_id')
            ->orderBy('team_index')
            ->lock()
            ->count();
    }

    /**
     * 参赛总人数
     * @param $game_room_id
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function totalCount($game_room_id)
    {
        return self::query()
            ->where('game_room_id', $game_room_id)
            ->whereNotNull('member_id')
            ->orderBy('team_index')
            ->lock()
            ->get();
    }


    /**
     * 今日参赛场次
     * @param $member_id
     * @param $competition_rule_id
     * @return int
     */
    public static function dailyParticipation($member_id, $competition_rule_id)
    {
        $start_at = strtotime(date('Ymd'));

        $end_at = $start_at + (60 * 60 * 24);

        return self::query()
            ->where('member_id', $member_id)
            ->whereHas('room', function ($query) use ($start_at, $end_at, $competition_rule_id) {
                $query->where('competition_rule_id', $competition_rule_id)
                    ->whereBetween('started_at', [$start_at, $end_at])
                    ->where('status', '>=', 1);
            })->count();
    }

    /**
     * @param $member_id
     * @param array $with
     * @return Builder|Model|object|static
     */
    public static function alreadyInRoom($member_id, $with = [])
    {
        return self::query()
            ->where('member_id', $member_id)
            ->whereHas('room', function ($query) {
                $query->where('started_at', '>', time())->whereIn('status', [1]);
            })->with($with)->first();
    }

    /**
     * @param $member_id
     * @param $game_room_id
     * @return bool
     */
    public static function inCurrentRoom($member_id, $game_room_id)
    {
        return self::query()
            ->where(function ($query) use ($member_id, $game_room_id) {
                $query->where('game_room_id', $game_room_id)
                    ->where('member_id', $member_id);
            })
            ->orWhere(function ($query) use ($member_id) {
                $query->where('member_id', $member_id)
                    ->whereHas('room', function ($query) {
                        $query->where('started_at', '>', time());
                    });
            })->exists();
    }

    /**
     * @param $member_id
     * @param $game_room_id
     * @param $with
     * @return Builder|Model|object|null|static
     */
    public static function findOneByMemberRoom($member_id, $game_room_id, $with = [])
    {
        return self::query()
            ->where('member_id', $member_id)
            ->where('game_room_id', $game_room_id)
            ->with($with)
            ->first();
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }

        if (!empty($this->game_room_id)) {
            $build = $build->where('game_room_id', $this->game_room_id);
        }

        if (isset($this->win)) {
            $build = $build->where('win', $this->win);
        }

        if (!empty($this->from_order_sn)) {
            $build = $build->where('from_order_sn', 'like', "%{$this->from_order_sn}%");
        }

        if (!empty($this->order_sn)) {
            $build = $build->where('order_sn', 'like', "%{$this->order_sn}%");
        }

        if (!empty($param['complete_at']) && (count($param['complete_at']) === 2)) {
            $build = $build->whereBetween('complete_at', [$param['complete_at'][0], $param['complete_at'][1]]);
        }


        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
