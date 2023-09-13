<?php

namespace App\Models\Admin;

use App\Models\Build\AdminBuild\AdminNavigationBuild;
use App\Models\Trait\CreatedBySet;
use App\Models\Trait\SearchData;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int id
 * @property int parent_id
 * @property string navigation_name
 * @property string navigation_link
 * @property string navigation_router
 * @property int navigation_sort
 * @property string icon
 * @property int created_by
 * @property Carbon created_at
 * @property User user
 * @property AdminNavigation[]|Collection children
 * @property AdminNavigation parent
 */
class AdminNavigation extends Model
{
    use SoftDeletes, CreatedBySet, AdminNavigationBuild, SearchData;

    protected $table = 'admin_navigations';

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
        'parent_id', 'navigation_name', 'navigation_link', 'navigation_router',
        'navigation_sort', 'icon', 'created_by'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(AdminNavigation::class, 'parent_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent()
    {
        return $this->hasOne(AdminNavigation::class, "id", "parent_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|static[]
     * */
    public static function getParentAll()
    {
        return self::query()->where(function ($query) {
            $query->orWhereNull('parent_id')->orWhere('parent_id', 0);
        })->get();
    }

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if ($this->navigation_name) {
            $build = $build->where('navigation_name', 'like', "%{$this->navigation_name}%");
        }
        return $build->with($with)->orderBy('id', 'desc');
    }

    /**
     * @param $navigation_name
     * @param $icon
     * @param $created_by
     * @param $sort
     * @param null $navigation_link
     * @param null $navigation_router
     * @return static|null
     */
    public static function generateParent($navigation_name, $icon, $created_by, $sort, $navigation_link = null, $navigation_router = null)
    {
        $model = new static();
        $model->setNavigationName($navigation_name)
            ->setIcon($icon)
            ->setNavigationSort($sort)
            ->setCreatedBy($created_by);
        if (empty($navigation_link)) {
            $model->setNavigationLink($navigation_link);
        }
        if (empty($navigation_router)) {
            $model->setNavigationRouter($navigation_router);
        }
        return $model->save() ? $model : null;
    }
}
