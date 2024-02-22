<?php

namespace App\Models\Goods;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\UnitRelation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string title
 * @property int day
 * @property int price
 * @property int unit_id
 * @property int show
 * @property int created_by
 * @property Carbon created_at
 */
class ProductVIP extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData, UnitRelation;

    protected $table = 'product_vips';
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
        'title', 'day', 'show', 'created_by', 'price', 'unit_id'
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
        if (isset($this->show)) {
            $build = $build->where('show', $this->show);
        }
        return $build->with($with)->orderBy('id', 'desc');
    }
}
