<?php

namespace App\Models\App;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property string content
 * @property int device
 * @property int update_method
 * @property string app_version
 * @property int app_version_code
 * @property string download_url
 * @property Carbon created_at
 */
class AppPublishLog extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'app_update_logs';

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
        'title', 'content', 'device', 'update_method',
        'app_version', 'app_version_code', 'download_url',
        'created_by', 'updated_by'
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
        if (!empty($this->app_version)) {
            $build = $build->where('app_version', 'like', "%{$this->app_version}%");
        }

        if (!empty($this->app_version_code)) {
            $build = $build->where('app_version_code', $this->app_version_code);
        }

        if (!empty($this->device)) {
            $build = $build->where('device', $this->device);
        }

        if (isset($this->update_method)) {
            $build = $build->where('update_method', $this->update_method);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
