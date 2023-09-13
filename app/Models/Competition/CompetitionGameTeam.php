<?php

namespace App\Models\Competition;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property string member_id
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class CompetitionGameTeam extends Model
{
    use HasFactory, SoftDeletes, MemberRelation, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_game_teams';

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
        'title', 'member_id', 'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (isset($this->title)) {
            $build = $build->where('title', $this->title);
        }

        if (!empty($param['created_at']) && (count($param['created_at']) === 2)) {
            $build = $build->whereBetween('created_at', [$param['created_at'][0], $param['created_at'][1]]);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
