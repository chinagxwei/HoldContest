<?php

namespace App\Http\Controllers\Backend\Wallet;

use App\Http\Controllers\PlatformController;
use App\Models\ActionLog;
use App\Models\Wallet\WalletWithdrawal;
use App\Service\Order\TradeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WalletWithdrawalController extends PlatformController
{
    protected $controller_event_text = "提现管理";

    public function index(Request $request)
    {
        $res = (new WalletWithdrawal())->searchBuild($request->all(), ['withdrawAccount','order'])
            ->orderBy('status','desc')
            ->orderBy('created_at','desc')
            ->paginate();
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
            DB::beginTransaction();
            try {
                $this->validate($request, [
                    'id' => 'required',
                    'status' => 'required',
                ]);

                if ($id > 0) {
                    $model = WalletWithdrawal::findOneByID($id);
                } else {
                    $model = new WalletWithdrawal();
                }

                $param = $request->all();

                if (intval($param['status']) === 0){
                    TradeService::withdrawCancel($id);
                }

                if ($model->fill($param)->save()) {
                    $text = [
                        $model->id,
                        $model->wallet_id,
                        $model->order_sn,
                        $model->amount
                    ];
                    $this->saveEvent(join(" | ", $text));
                    DB::commit();
                    return self::successJsonResponse();
                }
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error($e->getMessage());
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
            if ($model = WalletWithdrawal::findOneByID($id)) {
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
            if ($model = WalletWithdrawal::findOneByID($id)) {
                $text = [
                    $model->id,
                    $model->wallet_id,
                    $model->order_sn,
                    $model->amount
                ];
                $this->deleteEvent(join(" | ", $text));
                $model->delete();
                return self::successJsonResponse();
            }
        }

        return self::failJsonResponse();
    }
}
