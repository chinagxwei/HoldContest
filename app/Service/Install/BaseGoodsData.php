<?php

namespace App\Service\Install;

use App\Models\Goods\Goods;
use App\Models\Goods\ProductRecharge;
use App\Models\Goods\ProductVIP;
use Ramsey\Uuid\Uuid;

class BaseGoodsData
{
    public static function getData($created_by, $time)
    {
        $recharges = ProductRecharge::query()->get();
        $vips = ProductVIP::query()->get();

        $items = $recharges->map(function ($v) use ($time, $created_by) {
            return [
                'id' => Uuid::uuid4()->toString(),
                'title' => $v->title,
                'goods_type' => 2,
                'relation_category' => 2,
                'relation_id' => $v->id,
                'stock' => 999999,
                'bind' => ($v->denomination > 10000 || $v->give_amount > 0) ? 0 : 1,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ];
        });

        $items2 = $vips->map(function ($v) use ($time, $created_by) {
            return [
                'id' => Uuid::uuid4()->toString(),
                'title' => $v->title,
                'goods_type' => 2,
                'relation_category' => 1,
                'relation_id' => $v->id,
                'stock' => 999999,
                'bind' => 0,
                'created_by' => $created_by,
                'created_at' => $time,
                'updated_at' => $time
            ];
        });

        return array_merge($items->toArray(), $items2->toArray());
    }
}
