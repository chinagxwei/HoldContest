<?php

namespace App\Models\Competition;

use App\Models\BaseDataModel;
use App\Models\Goods\Goods;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\UnitRelation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property int game_id
 * @property string team_game
 * @property int quick
 * @property int participants_price
 * @property int unit_id
 * @property int participants_number
 * @property int start_number
 * @property int daily_participation_limit
 * @property int default_start_second
 * @property int default_end_second
 * @property string rule
 * @property string description
 * @property string remark
 * @property int status
 * @property int sort_order
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property CompetitionGame competitionGame
 * @property CompetitionRulePrize prizes
 */
class CompetitionRule extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData, UnitRelation;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_rules';

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
        'title', 'game_id', 'team_game', 'title', 'quick',
        'participants_price', 'unit_id', 'participants_number', 'start_number',
        'daily_participation_limit', 'default_start_second', 'default_end_second',
        'rule', 'description', 'remark', 'sort_order',
        'status', 'created_by', 'updated_by'
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function prizes()
    {
        return $this->hasMany(CompetitionRulePrize::class, 'competition_rule_id', 'id')->orderBy('ranking');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->game_id)) {
            $build = $build->where('game_id', $this->game_id);
        }

        if (!empty($this->unit_id)) {
            $build = $build->where('unit_id', $this->unit_id);
        }

        if (isset($this->team_game)) {
            $build = $build->where('team_game', $this->team_game);
        }

        if (!empty($this->title)) {
            $build = $build->where('title', 'like', "%{$this->title}%");
        }

        if (isset($this->quick)) {
            $build = $build->where('quick', $this->quick);
        }

        if (isset($this->status)) {
            $build = $build->where('status', $this->status);
        }


        if (!empty($this->rule)) {
            $build = $build->where('rule', 'like', "%{$this->rule}%");
        }

        if (!empty($this->description)) {
            $build = $build->where('description', 'like', "%{$this->description}%");
        }

        return $build->with($with);
    }
}
