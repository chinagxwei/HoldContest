<?php

namespace App\Models\Wechat;

use App\Models\Trait\CreatedRelation;
use App\Models\Trait\SearchData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property string member_id
 * @property string openid
 * @property string unionid
 * @property string nickname
 * @property int sex
 * @property string city
 * @property string province
 * @property string country
 * @property string headimgurl
 * @property int subscribe
 * @property int subscribe_at
 * @property int unsubscribe_at
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class WechatOfficeAccount extends Model
{
    use HasFactory, SoftDeletes, CreatedRelation, SearchData;

    protected $table = 'wechat_office_accounts';
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
        'member_id', 'openid', 'unionid',
        'nickname', 'sex', 'city',
        'province', 'country', 'headimgurl',
        'subscribe', 'subscribe_at', 'unsubscribe_at',
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

        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }

        if (!empty($this->nickname)) {
            $build = $build->where('nickname', 'like', "%{$this->nickname}%");
        }

        if (isset($this->sex)) {
            $build = $build->where('sex', $this->sex);
        }

        if (!empty($this->city)) {
            $build = $build->where('city', 'like', "%{$this->city}%");
        }

        if (!empty($this->province)) {
            $build = $build->where('province', 'like', "%{$this->province}%");
        }

        if (!empty($this->country)) {
            $build = $build->where('country', 'like', "%{$this->country}%");
        }

        if (isset($this->subscribe)) {
            $build = $build->where('subscribe', $this->subscribe);
        }

        if (!empty($param['subscribe_at']) && (count($param['subscribe_at']) === 2)) {
            $build = $build->whereBetween('subscribe_at', [$param['subscribe_at'][0], $param['subscribe_at'][1]]);
        }

        if (!empty($param['unsubscribe_at']) && (count($param['unsubscribe_at']) === 2)) {
            $build = $build->whereBetween('unsubscribe_at', [$param['unsubscribe_at'][0], $param['unsubscribe_at'][1]]);
        }

        return $build->with($with)->orderBy('id', 'desc');
    }
}
