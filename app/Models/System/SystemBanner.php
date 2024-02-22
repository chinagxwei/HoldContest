<?php

namespace App\Models\System;

use App\Models\BaseDataModel;
use App\Models\Build\SystemBuild\SystemAgreementBuild;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string id
 * @property string title
 * @property string url
 * @property string relation_id
 * @property int relation_type
 * @property int position
 * @property int show
 * @property int sort_order
 * @property Carbon created_at
 */
class SystemBanner extends BaseDataModel
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SearchData;

    protected $table = 'system_banners';

    protected $keyType = 'string';

    const POSITION_HOME = 1;

    const POSITION_ROOM_LIST = 2;

    const POSITION_ROOM_DETAIL = 3;

    const POSITION_USERINFO = 4;

    const POSITION_SQUARE = 5;

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
        'title', 'url', 'relation_id', 'relation_type', 'position', 'show', 'sort_order', 'created_by'
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

        if (isset($this->position)) {
            $build = $build->where('position', $this->position);
        }

        if (isset($this->show)) {
            $build = $build->where('show', $this->show);
        }

        if (isset($this->relation_type)) {
            $build = $build->where('position', $this->relation_type);
        }

        return $build->with($with)->orderBy('sort_order', 'desc');
    }
}
