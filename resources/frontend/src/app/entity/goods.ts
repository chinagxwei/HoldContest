import {Unit} from "./system";

export class Goods {
  id?: string;
  title: string = "";
  description: string = "";
  goods_type: number = 0;
  relation_category: number = 0;
  relation_id: number = 0;
  stock?: number = 0;
  status?: number;
  bind?: number;
  started_at: number = 0;
  ended_at: number = 0;
  sort: number = 0;
  remark: string = "";
  created_at?: number;
  vip?: ProductVIP;
  recharge?: ProductRecharge;
}

export class Product {
  id?: number;
  title: string = "";
}

export class ProductRecharge extends Product {
  denomination: number = 0;
  give_amount: number = 0;
  unit_id: number = 0;
  show?: number;
  created_at?: number;
  unit?: Unit
}

export class ProductVIP extends Product {
  day: number = 0;
  show: number = 0;
  price: number = 0;
  unit_id: number = 0;
  created_at?: number;
  unit?: Unit
}


