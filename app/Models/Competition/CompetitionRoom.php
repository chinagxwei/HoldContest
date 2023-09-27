<?php

namespace App\Models\Competition;

use App\Models\BaseDataModel;
use App\Models\Member\MemberCompetition;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property string id
 * @property int competition_rule_id
 * @property string game_room_name
 * @property int game_room_code
 * @property int game_room_pwd
 * @property int status
 * @property int quick
 * @property int complete
 * @property int interval
 * @property string link
 * @property string link_hash
 * @property int ready_at
 * @property int started_at
 * @property int ended_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property CompetitionRule competitionRule
 * @property MemberCompetition[]|Collection participants
 */
class CompetitionRoom extends BaseDataModel
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_rooms';

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
        'competition_rule_id', 'game_room_name', 'game_room_code',
        'status', 'quick', 'complete', 'game_room_pwd',
         'interval', 'ready_at',
        'started_at', 'ended_at', 'created_by',
        'updated_by', 'link', 'link_hash'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    const CANCEL_STAGE = -1;
    const STARTING_STAGE = 1;
    const REVIEW_STAGE = 2;
    const END_STAGE = 3;

    /**
     * @return $this
     */
    public function setReviewStage()
    {
        $this->status = self::REVIEW_STAGE;
        return $this;
    }

    /**
     * @return $this
     */
    public function setCancelStage()
    {
        $this->status = self::CANCEL_STAGE;
        return $this;
    }

    /**
     * @return $this
     */
    public function setEndStage()
    {
        $this->status = self::END_STAGE;
        $this->complete = self::ENABLE;
        $this->ended_at = time();
        return $this;
    }

    /**
     * @return bool
     */
    public function isQuickRoom(){
        return $this->quick === self::ENABLE;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function competitionRule()
    {
        return $this->hasOne(CompetitionRule::class, 'id', 'competition_rule_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany(MemberCompetition::class, 'game_room_id', 'id')
            ->where(function ($query) {
                $query->whereNotNull('member_id')->orWhere('member_id', '<>', '');
            });
    }

    /**
     * @param $competition_rule_id
     * @param array $with
     * @return Builder|Model|object|null|static
     */
    public static function getLastOne($competition_rule_id, $with = [])
    {
        return self::query()
            ->where('competition_rule_id', $competition_rule_id)
            ->orderBy('game_room_code', 'desc')
            ->with($with)
            ->first();
    }

    /**
     * @param $time
     * @param $with
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function findAllBegun($time, $with = [])
    {
        return self::query()
            ->where('started_at', '<=', $time)
            ->where('status', self::STARTING_STAGE)
            ->with($with)
            ->get();
    }

    /**
     * @param $competition_rule_id
     * @return int
     */
    public static function getAvailableRoomNumber($competition_rule_id)
    {
        return self::query()
            ->where('competition_rule_id', $competition_rule_id)
            ->where('started_at', 0)
            ->where('ready_at', 0)
            ->count();
    }

    /**
     * @param $competition_rule_id
     * @param $num
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAvailableRooms($competition_rule_id, $num)
    {
        return self::query()
            ->where('competition_rule_id', $competition_rule_id)
            ->where('started_at', 0)
            ->where('ready_at', 0)
            ->orderBy('game_room_code')
            ->take($num)
            ->get();
    }

    /**
     * @param $id
     * @param $with
     * @return \Illuminate\Database\Eloquent\Builder|Model|object|null|static
     */
    public static function findUseOneByID($id, $with = [])
    {
        return self::query()
            ->where('id', $id)
            ->where('status', self::STARTING_STAGE)
            ->with($with)
            ->first();
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->competition_rule_id)) {
            $build = $build->where('competition_rule_id', $this->competition_rule_id);
        }

        if (!empty($this->game_room_name)) {
            $build = $build->where('game_room_name', 'like', "%{$this->game_room_name}%");
        }

        if (!empty($this->game_room_code)) {
            $build = $build->where('game_room_code', $this->game_room_code);
        }

        if (isset($this->status)) {
            $build = $build->where('status', $this->status);
        }

        if (isset($this->quick)) {
            $build = $build->where('quick', $this->quick);
        }

        if (isset($this->complete)) {
            $build = $build->where('complete', $this->complete);
        }

        if (!empty($this->interval)) {
            $build = $build->where('interval', $this->interval);
        }

        if (!empty($param['created_at']) && (count($param['created_at']) === 2)) {
            $build = $build->whereBetween('created_at', [$param['created_at'][0], $param['created_at'][1]]);
        }

        return $build->with($with);
    }
}
