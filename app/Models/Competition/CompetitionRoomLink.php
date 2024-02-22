<?php

namespace App\Models\Competition;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int room_id
 * @property int game_id
 * @property string link
 * @property string md5
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property CompetitionRoom competitionRoom
 * @property CompetitionGame competitionGame
 */
class CompetitionRoomLink extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_room_links';

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
        'room_id', 'game_id', 'link', 'md5',
        'created_by', 'updated_by', 'created_at'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function competitionRoom()
    {
        return $this->hasOne(CompetitionRoom::class, 'id', 'room_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function competitionGame()
    {
        return $this->hasOne(CompetitionGame::class, 'id', 'game_id');
    }

    /**
     * @return int
     */
    public static function getAvailableLinkNumber($game_id)
    {
        return self::query()->where('game_id', $game_id)->whereNull('room_id')->count();
    }

    /**
     * @param $game_id
     * @param $num
     * @return Builder[]|Collection|static[]
     */
    public static function getAvailableLink($game_id, $num)
    {
        return self::query()->where('game_id', $game_id)->whereNull('room_id')->take($num)->get();
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->room_id)) {
            $build = $build->where('room_id', $this->room_id);
        }
        if (!empty($this->game_id)) {
            $build = $build->where('game_id', $this->game_id);
        }
        return $build->with($with);
    }
}
