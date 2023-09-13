export class Goods {
  id?: string;
  title: string = "";
  description: string = "";
  stock: number = 0;
  status: number = 0;
  bind: number = 0;
  started_at: number = 0;
  ended_at: number = 0;
  sort: number = 0;
  remark: string = "";
  created_at?: number;
}

export class ProductRecharge {
  id?: number;
  title: string = "";
  denomination: number = 0;
  give_amount: number = 0;
  unit_id: number = 0;
  show: number = 0;
  created_at?: number;
}

export class ProductVip {
  id?: number;
  title: string = "";
  day: number = 0;
  show: number = 0;
  created_at?: number;
}
