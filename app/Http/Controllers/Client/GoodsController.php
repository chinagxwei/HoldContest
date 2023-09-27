<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\Goods\Goods;
use App\Models\Order\Order;
use App\Models\Order\OrderIncome;
use App\Models\User;
use Illuminate\Http\Request;

class GoodsController extends PlatformController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['goodsList']]);
    }

    /**
     * 商品列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsList(Request $request)
    {
        $title = $request->input('title', '');
        $res = (new Goods())->searchBuild(['title' => $title])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * 商品详情
     * @return \Illuminate\Http\JsonResponse
     */
    public function goodsDetails(Request $request)
    {
        if ($id = $request->input('goods_id')) {
            if ($model = Goods::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 商品交易
     * @return void
     */
    public function trade(Request $request)
    {

    }

    /**
     * 商品订单
     * @return \Illuminate\Http\JsonResponse
     */
    public function orders(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            $param = $request->all();
            $param['member_id'] = $member_id;
            $res = (new Order())->searchBuild($param)->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }

    /**
     * 商品订单收益
     * @return \Illuminate\Http\JsonResponse
     */
    public function orderIncomes(Request $request)
    {
        /** @var User $user */
        $user = auth('api')->user();
        if ($member_id = $user->getMemberID()) {
            $param = $request->all();
            $param['member_id'] = $member_id;
            $res = (new OrderIncome())->searchBuild($param)->paginate();
            return self::successJsonResponse($res);
        }

        return self::failJsonResponse("未获取到相关数据");
    }
}
