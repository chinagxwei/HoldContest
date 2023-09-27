export class Order {
  id?: string;
  sn: string = "";
  third_party_payment_sn: string = "";
  third_party_merchant_id: string = "";
  order_category: number = 1;
  member_id: string = "";
  pay_method: number = 1;
  unit_id: number = 1;
  pay_at: number = 1;
  pay_status: number = 0;
  total_amount: number = 0;
  reduce_amount: number = 0;
  pay_amount: number = 0;
  commission_amount: number = 0;
  real_income_amount: number = 0;
  cancel_at: number = 0;
  remark: string = "";
  created_at?: number;
}

export class OrderCart {
  id?: number;
  member_id: string = "";
  order_sn: string = "";
  goods_id: number = 0;
  purchase_volume: number = 0;
  remark: string = "";
  created_at?: number;
}

export class OrderIncome {
  id?: number;
  member_id: string = "";
  from_order_sn: string = "";
  to_order_sn: string = "";
  amount: number = 0;
  created_at?: number;
}

export class OrderIncomeConfig {
  id?: number;
  title: string = "";
  vip_commission: number = 0;
  recharge_commission: number = 0;
  consume_commission: number = 0;
  level_1_play_commission: number = 0;
  level_2_play_commission: number = 0;
  agent_commission: number = 0;
  withdraw_point: number = 0;
  vip_withdraw_point: number = 0;
  created_at?: number;
}
