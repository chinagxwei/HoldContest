<?php

namespace App\Models\Admin;

use App\Models\Build\AdminBuild\AdminBuild;
use App\Models\Trait\AdminRoleRelation;
use App\Models\Trait\SearchData;
use App\Models\User;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property int role_id
 * @property string nickname
 * @property string mobile
 * @property string remark
 * @property int created_by
 * @property Carbon created_at
 * @property User user
 * @property AdminMessage[]|Collection readMessageLogs
 * @property AdminRole role
 */
class Admin extends Model
{
    use HasFactory, SoftDeletes, Uuids, AdminBuild, AdminRoleRelation, SearchData;

    protected $table = 'admins';

    protected $fillable = [
        'role_id', 'nickname','mobile', 'remark', 'created_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function readMessageLogs()
    {
        return $this->belongsToMany(
            AdminMessage::class,
            'admin_read_message_logs',
            'message_id',
            'admin_id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(AdminRole::class, 'id', 'role_id');
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->role_id)) {
            $build = $build->where('role_id', $this->role_id);
        }
        return $build->with($with)->orderBy('id', 'desc');
    }
}
