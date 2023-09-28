<?php

namespace App\Models\Member;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string title
 * @property string content
 * @property int weight
 * @property int created_by
 * @property int updated_by
 * @property int created_at
 */
class MemberMessage extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    protected $table = 'member_messages';
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
        'title', 'content', 'weight','created_by', 'updated_by'
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
            $build = $build->where('content', 'like', "%{$this->content}%");
        }

        if (!empty($this->weight)) {
            $build = $build->where('weight', $this->weight);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
