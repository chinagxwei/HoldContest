<?php

namespace App\Models\Trait;

use App\Models\Goods\Goods;

/**
 * @property int goods_id
 * @property Goods goods
 */
trait GoodsRelation
{
    public function setGoods($goods_id)
    {
        $this->goods_id = $goods_id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function goods()
    {
        return $this->hasOne(Goods::class, 'id', 'goods_id');
    }
}
