<?php

namespace App\Models\Admin;

use App\Models\Build\AdminBuild\AdminMessageBuild;
use App\Models\Trait\CreatedBySet;
use App\Models\Trait\SearchData;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string title
 * @property string content
 * @property int weight
 * @property int created_by
 * @property Carbon created_at
 * @property User user
 */
class AdminMessage extends Model
{
    use HasFactory, SoftDeletes, CreatedBySet, AdminMessageBuild, SearchData;

    protected $table = 'admin_messages';

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
        'title', 'content', 'weight', 'created_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];


    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
    }
}
