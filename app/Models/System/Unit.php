<?php

namespace App\Models\System;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property int title
 * @property int description
 * @property int label
 * @property int symbol
 * @property int finance
 * @property int created_by
 * @property Carbon created_at
 */
class Unit extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    protected $table = 'units';
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
        'title', 'description', 'label', 'symbol', 'created_by', 'finance'
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

        if (isset($this->finance)) {
            $build = $build->where('finance', $this->finance);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
