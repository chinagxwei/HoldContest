<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\PlatformController;
use App\Models\BaseDataModel;
use App\Models\System\SystemBanner;
use Illuminate\Http\Request;

class BannerController extends PlatformController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function home(Request $request)
    {
        $param = $request->all();
        $param['position'] = SystemBanner::POSITION_HOME;
        $param['show'] = BaseDataModel::ENABLE;
        $res = (new SystemBanner())->searchBuild()->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function roomList(Request $request)
    {
        $param = $request->all();
        $param['position'] = SystemBanner::POSITION_ROOM_LIST;
        $param['show'] = BaseDataModel::ENABLE;
        $res = (new SystemBanner())->searchBuild()->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function roomDetail(Request $request)
    {
        $param = $request->all();
        $param['position'] = SystemBanner::POSITION_ROOM_DETAIL;
        $param['show'] = BaseDataModel::ENABLE;
        $res = (new SystemBanner())->searchBuild()->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function userinfo(Request $request)
    {
        $param = $request->all();
        $param['position'] = SystemBanner::POSITION_USERINFO;
        $param['show'] = BaseDataModel::ENABLE;
        $res = (new SystemBanner())->searchBuild()->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function square(Request $request)
    {
        $param = $request->all();
        $param['position'] = SystemBanner::POSITION_SQUARE;
        $param['show'] = BaseDataModel::ENABLE;
        $res = (new SystemBanner())->searchBuild()->paginate();
        return self::successJsonResponse($res);
    }
}
