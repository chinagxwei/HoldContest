<?php

namespace App\Models\System;

use App\Models\Build\SystemBuild\SystemConfigBuild;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string key
 * @property string value
 * @property int created_by
 * @property Carbon created_at
 */
class SystemConfig extends Model
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SystemConfigBuild, SearchData;

    protected $table = 'system_configs';
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
        'key', 'value', 'created_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->key)) {
            $build = $build->where('key', 'like', "%{$this->key}%");
        }
        if (!empty($this->value)) {
            $build = $build->where('value', 'like', "%{$this->value}%");
        }
        return $build->with($with)->orderBy('id', 'desc');
    }
}
