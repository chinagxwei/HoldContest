<?php

namespace App\Models\Wallet;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property int level
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class Wallet extends Model
{
    use HasFactory, SoftDeletes, Uuids, CreatedRelation, SearchData;

    protected $table = 'wallets';
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
        'level'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;

        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
