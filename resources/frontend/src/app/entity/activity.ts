export class Quest {
  id?: number;
  title: string = "";
  description?: string = "";
  started_at?: number = 0;
  ended_at?: number = 0;
  status?: number = 0;
  auto_start?: number = 0;
  participate_count?: number = 0;
  created_at?: number = 0;
}

export class LuckyDrawsItem {
  id?: number;
  title: string = "";
  image?: string = "";
  goods_id?: number = 0;
  status?: number = 0;
  created_at?: number = 0;
}

export class LuckyDrawsConfig {
  id?: number;
  title: string = "";
  total?: number = 0;
  status?: number = 0;
  started_at?: number = 0;
  ended_at?: number = 0;
  created_at?: number = 0;
}
