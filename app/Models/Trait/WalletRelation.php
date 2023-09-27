<?php

namespace App\Models\Trait;

use App\Models\Wallet\Wallet;


/**
 * @property int wallet_id
 * @property Wallet wallet
 */
trait WalletRelation
{
    public function setWallet($wallet_id){
        $this->wallet_id = $wallet_id;
        return $this;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'id', 'wallet_id');
    }
}
