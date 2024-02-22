<?php

namespace App\Service\Wallet;

use App\Models\Order\Order;
use App\Models\Wallet\Wallet;
use App\Models\Wallet\WalletConsume;
use App\Models\Wallet\WalletLog;
use App\Models\Wallet\WalletRecharge;
use App\Models\Wallet\WalletUnit;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    /** @var Order */
    private $order;

    /** @var Wallet */
    private $wallet;

    /** @var int 订单剩余支付额度 */
    private $lastAmount;

    /** @var array */
    private $reduceAmount = [];

    /** @var array */
    private $rechargesArray = [];

    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function setWallet($wallet)
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @return true
     * @throws \Exception
     */
    public function execute()
    {
        if (empty($this->order) || empty($this->wallet)) {
            throw new \Exception('支付对象错误');
        }
        $this->lastAmount = $this->order->pay_amount;
        $this->rechargesArray = WalletRecharge::findAllByWallet($this->wallet->id, $this->order->unit_id)->toArray();
        $this->handleReduceAmount();
        return true;
    }

    /**
     * @throws \Exception
     */
    private function handleReduceAmount()
    {
        if ($this->lastAmount > 0) {
            $this->rechargesArray = array_map(function ($recharge) {
                if ($this->lastAmount > 0 && $recharge['balance'] !== 0) {
                    if ($this->lastAmount >= $recharge['balance']) {
                        // 当订单剩余额度大于等于充值记录剩余额度，扣除充值记录额度
                        $this->reduceAmount[] = [
                            'id' => $recharge['id'],
                            'wallet_id' => $recharge['wallet_id'],
                            'reduce_amount' => $recharge['balance'],
                            'validate_complete' => false
                        ];
                        $this->lastAmount = $this->lastAmount - $recharge['balance'];
                        $recharge['balance'] = 0;
                    } else {
                        // 当订单剩余额度小于充值记录剩余额度，扣除订单剩余额度
                        $this->reduceAmount[] = [
                            'id' => $recharge['id'],
                            'wallet_id' => $recharge['wallet_id'],
                            'reduce_amount' => $this->lastAmount,
                            'validate_complete' => false
                        ];
                        $recharge['balance'] = $recharge['balance'] - $this->lastAmount;
                        $this->lastAmount = 0;
                    }
                }
                return $recharge;
            }, $this->rechargesArray);
        }
        $this->generateWalletConsume();
        $this->validate();
        $this->generateWalletLog();
    }

    private function generateWalletConsume()
    {
        foreach ($this->reduceAmount as $key => $item) {
            $res = WalletRecharge::query()
                ->where('id', $item['id'])
                ->decrement('balance', $item['reduce_amount']);
            if ($res) {
                $this->reduceAmount[$key]['validate_complete'] = true;
                WalletConsume::generate($this->wallet->id, $item['id'], $this->order->sn, $this->order->member_id, $item['reduce_amount']);
            }
        }
    }

    /**
     * @throws \Exception
     */
    private function generateWalletLog()
    {
        $total_balance = WalletRecharge::getTotalBalance($this->wallet->id, $this->order->unit_id);
        WalletLog::output($this->wallet->id, $this->order->sn, $this->order->pay_amount, $total_balance, $this->order->unit_id);
        if (WalletUnit::hasRow($this->wallet->id, $this->order->unit_id)) {
            $this->wallet->setTotalBalanceByUnit($this->order->unit_id, $total_balance);
        } else {
            $this->wallet->addTotalBalanceByUnit($this->order->unit_id, $total_balance);
        }
    }

    /**
     * @throws \Exception
     */
    private function validate(){
        $completeAmount = 0;
        foreach ($this->reduceAmount as $item) {
            if ($item['validate_complete']) {
                $completeAmount = $completeAmount + $item['reduce_amount'];
            }
        }
        Log::info("========= complete amount: {$completeAmount} =========");
        Log::info("========= order pay amount: {$this->order->pay_amount} =========");
        if ($completeAmount !== $this->order->pay_amount) {
            throw new \Exception('支付校验失败！');
        }
    }
}
