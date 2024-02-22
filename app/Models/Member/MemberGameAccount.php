<?php

namespace App\Models\Member;

use App\Models\Competition\CompetitionGame;
use App\Models\Trait\CreatedRelation;
use App\Models\Trait\MemberRelation;
use App\Models\Trait\SearchData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property string member_id
 * @property int game_id
 * @property int account_type
 * @property string nickname
 * @property string game_code
 * @property int created_by
 * @property int updated_by
 * @property Carbon created_at
 */
class MemberGameAccount extends Pivot
{
    use HasFactory, SoftDeletes, CreatedRelation, MemberRelation, SearchData;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'member_game_accounts';

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
        'member_id', 'game_id', 'account_type',
        'nickname', 'game_code',
        'created_by', 'updated_by'
    ];

    protected $hidden = [
        'deleted_at', 'updated_at'
    ];

    /**
     * @param $member_id
     * @param $game_id
     * @param $account_type
     * @param $nickname
     * @param $game_code
     * @return $this|null
     */
    public static function generate($member_id, $game_id, $account_type, $nickname, $game_code)
    {
        $model = new static();
        $model->member_id = $member_id;
        $model->game_id = $game_id;
        $model->account_type = $account_type;
        $model->nickname = $nickname;
        $model->game_code = $game_code;
        return $model->save() ? $model : null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function game()
    {
        return $this->hasOne(CompetitionGame::class, "id", "game_id");
    }

    function searchBuild($param = [], $with = [])
    {
        // TODO: Implement searchBuild() method.
        $this->fill($param);
        $build = $this;
        if (!empty($this->member_id)) {
            $build = $build->where('member_id', $this->member_id);
        }

        if (!empty($this->game_id)) {
            $build = $build->where('game_id', $this->game_id);
        }

        if (isset($this->account_type)) {
            $build = $build->where('account_type', $this->account_type);
        }

        if (!empty($this->nickname)) {
            $build = $build->where('nickname', 'like', "%{$this->nickname}%");
        }

        if (!empty($this->game_code)) {
            $build = $build->where('game_code', $this->game_code);
        }


        return $build->with($with)->orderBy('created_by', 'desc');
    }
}
