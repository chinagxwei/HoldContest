<?php

namespace App\Models\Wallet;

use App\Models\BaseDataModel;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use App\Models\Trait\SignData;
use Carbon\Carbon;
use Emadadly\LaravelUuid\Uuids;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string id
 * @property string member_id
 * @property int account_type
 * @property string contact
 * @property string mobile
 * @property string account
 * @property string bank_name
 * @property string sign
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class WalletWithdrawalAccount extends BaseDataModel
{
    use HasFactory, SoftDeletes, Uuids, MemberRelation, CreatedRelation, SignData, SearchData;

    protected $table = 'wallet_withdraw_accounts';

    protected $keyType = 'string';
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
        'member_id', 'account_type', 'contact',
        'mobile', 'account', 'bank_name',
        'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @param $member_id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null|static
     */
    public static function findOneByMember($member_id)
    {
        return self::query()->where('member_id', $member_id)->first();
    }

    /**
     * @param $id
     * @param $member_id
     * @return Builder|Model|object|null|static
     */
    public static function findOneByMemberAndID($id, $member_id)
    {
        return self::query()
            ->where('id', $id)
            ->where('member_id', $member_id)
            ->first();
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;

        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }
        if (isset($this->account_type)) {
            $build = $build->where('account_type', $this->account_type);
        }

        if (!empty($this->contact)) {
            $build = $build->where('contact', 'like', "%{$this->contact}%");
        }

        if (!empty($this->mobile)) {
            $build = $build->where('mobile', 'like', "%{$this->mobile}%");
        }

        if (!empty($this->account)) {
            $build = $build->where('account', 'like', "%{$this->account}%");
        }

        if (!empty($this->bank_name)) {
            $build = $build->where('bank_name', 'like', "%{$this->bank_name}%");
        }

        return $build->with($with)->orderBy('id', 'desc');
    }

    function setSign()
    {
        // TODO: Implement setSign() method.
        $raw = [
            $this->member_id ?? 0,
            $this->account_type ?? 0,
            $this->contact ?? 0,
            $this->mobile ?? '',
            $this->account ?? '',
            $this->bank_name ?? '',
        ];

        $this->sign = sha1(join('_', $raw));
    }
}
