<?php

namespace App\Models\Competition;

use App\Models\Goods\Goods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;


/**
 * @property int competition_rule_id
 * @property int ranking
 * @property int goods_id
 * @property Goods goods
 * @property CompetitionRule competitionRule
 */
class CompetitionRulePrize extends Pivot
{
    use HasFactory;

    /**
     * 与模型关联的数据表。
     *
     * @var string
     */
    protected $table = 'competition_rule_prizes';

    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function goods()
    {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function competitionRule(){
        return $this->belongsTo(CompetitionRule::class,'competition_rule_id','id');
    }
}
