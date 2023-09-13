<?php

namespace App\Models\Competition;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string team_game
 * @property string game_name
 * @property int quick
 * @property int participants_price
 * @property int participants_number
 * @property int start_number
 * @property string rule
 * @property string description
 * @property string remark
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class CompetitionGame extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_games';

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
        'team_game', 'game_name', 'quick',
        'participants_price', 'participants_number', 'start_number',
        'rule', 'description', 'remark', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (isset($this->team_game)) {
            $build = $build->where('team_game', $this->team_game);
        }

        if (!empty($this->game_name)) {
            $build = $build->where('game_name', 'like', "%{$this->game_name}%");
        }

        if (isset($this->quick)) {
            $build = $build->where('quick', $this->quick);
        }

        if (!empty($this->rule)) {
            $build = $build->where('rule', 'like', "%{$this->rule}%");
        }

        if (!empty($this->description)) {
            $build = $build->where('description', 'like', "%{$this->description}%");
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
