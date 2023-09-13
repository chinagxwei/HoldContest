<?php

namespace App\Models\Competition;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string id
 * @property int game_id
 * @property string game_room_name
 * @property int status
 * @property int quick
 * @property int complete
 * @property string game_room_qrcode
 * @property int interval
 * @property int ready_at
 * @property int started_at
 * @property int ended_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property CompetitionGame competitionGame
 */
class CompetitionRoom extends Model
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_rooms';

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
        'game_id', 'game_room_name', 'status',
        'quick', 'complete', 'game_room_qrcode',
        'interval', 'ready_at', 'started_at',
        'ended_at', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function competitionGame()
    {
        return $this->hasOne(CompetitionGame::class, 'id', 'game_id');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->game_id)) {
            $build = $build->where('game_id', $this->game_id);
        }

        if (!empty($this->game_room_name)) {
            $build = $build->where('game_room_name', 'like', "%{$this->game_room_name}%");
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

        return $build->with($with)->orderBy('id', 'desc');
    }
}
