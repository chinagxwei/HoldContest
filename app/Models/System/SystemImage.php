<?php

namespace App\Models\System;

use App\Models\Build\SystemBuild\SystemImageBuild;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string title
 * @property string description
 * @property string url
 * @property int created_by
 * @property Carbon created_at
 */
class SystemImage extends Model
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SearchData, SystemImageBuild;

    protected $table = 'system_images';
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
        'title', 'description', 'url', 'created_by'
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
        if (!empty($this->content)) {
            $build = $build->where('description', 'like', "%{$this->description}%");
        }
        return $build->with($with)->orderBy('id', 'desc');
    }
}
