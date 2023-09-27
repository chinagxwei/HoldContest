<?php

namespace App\Service\Wallet;

use App\Models\Order\Order;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletConsume;
use App\Models\Wallet\WalletLog;
use App\Models\Wallet\WalletRecharge;
use App\Models\Wallet\WalletUnit;
use Illuminate\Support\Facades\Log;

class RefundService
{
    /** @var Order */
    private $order;


    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        if (empty($this->order)) {
            throw new \Exception('退款对象错误');
        }

        if ($this->order->isCancel()) {
            throw new \Exception('订单已取消');
        }

        Log::info("========= 退款订单：{$this->order->sn} =========");

        $consume = WalletConsume::findAllByOrderSN($this->order->sn,true);

        foreach ($consume as $item){
            $item->rollback()->save();
        }

        $total_balance = WalletRecharge::getTotalBalance($this->order->member->wallet_id, $this->order->unit_id);

        WalletLog::input($this->order->member->wallet_id, $this->order->sn, $this->order->pay_amount, $total_balance, $this->order->unit_id);

        if (WalletUnit::hasRow($this->order->member->wallet_id, $this->order->unit_id)) {
            $this->order->member->wallet->setTotalBalanceByUnit($this->order->unit_id, $total_balance);
        } else {
            $this->order->member->wallet->addTotalBalanceByUnit($this->order->unit_id, $total_balance);
        }

        return $this->order->setCancel()->save();
    }
}
