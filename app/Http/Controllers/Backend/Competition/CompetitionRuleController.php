<?php

namespace App\Http\Controllers\Backend\Competition;

use App\Http\Controllers\PlatformController;
use App\Models\Competition\CompetitionRule;
use App\Models\Competition\CompetitionRulePrize;
use App\Service\Competition\CompetitionEventService;
use Cassandra\Date;
use Illuminate\Http\Request;

class CompetitionRuleController extends PlatformController
{
    protected $controller_event_text = "比赛游戏规则";

    public function index(Request $request)
    {
        $res = (new CompetitionRule())->searchBuild($request->all(), ['competitionGame', 'prizes.goods'])->paginate();
        return self::successJsonResponse($res);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function save(Request $request)
    {
        if ($request->isMethod('POST')) {
            $id = $request->input('id');

            try {
                $this->validate($request, [
                    'title' => 'required',
                    'team_game' => 'numeric',
                    'game_id' => 'numeric',
                    'quick' => 'numeric',
                    'participants_price' => 'numeric',
                    'participants_number' => 'numeric',
                    'start_number' => 'numeric',
                    'rule' => 'required',
                ]);

                if ($id > 0) {
                    $model = CompetitionRule::findOneByID($id);
                } else {
                    $model = new CompetitionRule();
                }
                $param = $request->all();
                $today = strtotime(date('Ymd'));
                if (!empty($param['default_start_second'])) {
                    $param['default_start_second'] = intval($param['default_start_second']) - $today;
                }

                if (!empty($param['default_end_second'])) {
                    $param['default_end_second'] = intval($param['default_end_second']) - $today;
                }

                if ($model->fill($param)->save()) {
                    $this->saveEvent($model->title);

                    CompetitionEventService::competitionRuleAfter($model->id, $model->start_number);

                    return self::successJsonResponse();
                }
            } catch (\Exception $e) {
                return self::failJsonResponse($e->getMessage());
            }
        }
        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(Request $request)
    {
        if ($request->isMethod('POST') && $id = $request->input('id')) {
            if ($model = CompetitionRule::findOneByID($id)) {
                return self::successJsonResponse($model);
            }
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        if ($id = $request->input('id')) {
            if ($model = CompetitionRule::findOneByID($id)) {
                $this->deleteEvent($model->title);
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function configPrize(Request $request)
    {
        $param = $request->all();
        if (!empty($param['id'])) {
            if ($model = CompetitionRule::findOneByID($param['id'])) {
                foreach ($param['prizes'] as $key => $value) {
                    if (empty($value)) {
                        continue;
                    }
                    $model->prizes()
                        ->where('ranking', $key)->update([
                            'goods_id' => $value
                        ]);
                }
                return self::successJsonResponse();
            }
            return self::failJsonResponse('规则对象异常');
        }
        return self::failJsonResponse('规则ID异常');
    }
}
