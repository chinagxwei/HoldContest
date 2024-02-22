<?php

namespace App\Models\Member;

use App\Models\BaseDataModel;
use App\Models\Trait\BelongToSearchMemberData;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string member_id
 * @property int default
 * @property string contact
 * @property string mobile
 * @property string province_name
 * @property string city_name
 * @property string county_name
 * @property string street_name
 * @property string detail_info
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class MemberAddress extends BaseDataModel
{
    use HasFactory, SoftDeletes, CreatedRelation, MemberRelation, SearchData, BelongToSearchMemberData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_addresses';

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
        'member_id', 'default', 'contact',
        'mobile', 'province_name', 'city_name',
        'county_name', 'street_name', 'detail_info',
        'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @return bool
     */
    public function setDefault()
    {
        self::query()
            ->where('member_id', $this->member_id)
            ->update([
            'default' => self::DISABLE
        ]);
        $this->default = self::ENABLE;
        return $this->save();
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }

        if (!empty($this->contact)) {
            $build = $build->where('contact', 'like', "%{$this->contact}%");
        }

        if (!empty($this->mobile)) {
            $build = $build->where('mobile', 'like', "%{$this->mobile}%");
        }

        if (!empty($this->province_name)) {
            $build = $build->where('province_name', 'like', "%{$this->province_name}%");
        }

        if (!empty($this->city_name)) {
            $build = $build->where('city_name', 'like', "%{$this->city_name}%");
        }

        if (!empty($this->county_name)) {
            $build = $build->where('county_name', 'like', "%{$this->county_name}%");
        }

        if (!empty($this->street_name)) {
            $build = $build->where('street_name', 'like', "%{$this->street_name}%");
        }

        if (!empty($this->detail_info)) {
            $build = $build->where('detail_info', 'like', "%{$this->detail_info}%");
        }


        return $build->with($with)->orderBy('id', 'desc');
    }
}
