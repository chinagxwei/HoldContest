export class Wallet {
  id?: string;
  sn: string = "";
  level: number = 0;
  created_at?: number;
}

export class WalletConsume {
  id?: number;
  order_sn: string = "";
  wallet_id: string = "";
  wallet_recharge_id: string = "";
  member_id: string = "";
  amount: number = 0;
  created_at?: number;
}

export class WalletLog {
  id?: number;
  order_sn: string = "";
  wallet_id: string = "";
  type: number = 1;
  amount: number = 0;
  created_at?: number;
}

export class WalletRecharge {
  id?: string;
  order_sn: string = "";
  wallet_id: string = "";
  denomination: number = 0;
  balance: number = 0;
  unit_id: number = 0;
  frozen: number = 0;
  channel: number = 1;
  gift: number = 0;
  created_at?: number;
}

export class WalletWithdrawAccount {
  id?: string;
  member_id: string = "";
  account_type: number = 0;
  contact: string = "";
  mobile: string = "";
  account: string = "";
  bank_name: string = "";
  created_at?: number;
}

export class WalletWithdrawal {
  id?: string;
  order_sn: string = "";
  wallet_id: string = "";
  third_party_payment_sn: string = "";
  third_party_merchant_id: string = "";
  amount: number = 0;
  created_at?: number;
  created_by: number = 0;
}
