<?php

namespace App\Models\Competition;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property int parent_id
 * @property string game_name
 * @property string description
 * @property string remark
 * @property int sort_order
 * @property int show
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 * @property CompetitionRule[]|Collection rules
 * @property CompetitionGame parent
 * @property CompetitionGame[]|Collection children
 */
class CompetitionGame extends BaseDataModel
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
        'game_name', 'description', 'remark', 'created_by', 'updated_by', 'sort_order', 'show'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rules()
    {
        return $this->hasMany(CompetitionRule::class, 'game_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(CompetitionGame::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(CompetitionGame::class, 'id', 'parent_id');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;

        if (!empty($this->game_name)) {
            $build = $build->where('game_name', 'like', "%{$this->game_name}%");
        }

        if (!empty($this->remark)) {
            $build = $build->where('remark', 'like', "%{$this->remark}%");
        }

        if (!empty($this->description)) {
            $build = $build->where('description', 'like', "%{$this->description}%");
        }
        if (isset($this->show)){
            $build = $build->where('show', $this->show);
        }

        return $build->with($with);
    }
}
