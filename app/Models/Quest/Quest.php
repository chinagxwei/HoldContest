<?php

namespace App\Models\Quest;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property string description
 * @property int started_at
 * @property int ended_at
 * @property int status
 * @property int auto_start
 * @property int participate_count
 * @property int created_by
 * @property Carbon created_at
 */
class Quest extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation,SearchData;

    protected $table = 'quests';
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
        'title', 'description', 'started_at', 'ended_at',
        'status', 'auto_start', 'participate_count', 'created_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->title)) {
            $build = $build->where('title', 'like', "%{$this->title}%");
        }
        if (!empty($this->description)) {
            $build = $build->where('description', 'like', "%{$this->description}%");
        }
        if (isset($this->status)) {
            $build = $build->where('status', $this->status);
        }
        if (isset($this->auto_start)) {
            $build = $build->where('auto_start', $this->auto_start);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
