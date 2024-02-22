<?php

namespace App\Models\LuckyDraws;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property int total
 * @property int status
 * @property int started_at
 * @property int ended_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class LuckyDrawsConfig extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'lucky_draws_configs';

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
        'title', 'total', 'status', 'started_at',
        'ended_at', 'created_by', 'updated_by'
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

        if (isset($this->status)) {
            $build = $build->where('status', $this->status);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
