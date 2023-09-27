export class Member {
  id?: string;
  wallet_id: string = "";
  order_income_config_id: string = "";
  remark: string = "";
  parent_id: string = "";
  belong_agent_node: string = "";
  mobile: string = "";
  promotion_sn: string = "";
  develop: number = 0;
  register_type: number = 0;
  created_at?: number;
}

export class MemberAddress {
  id?: number;
  member_id: string = "";
  default: number = 0;
  contact: string = "";
  mobile: string = "";
  province_name: string = "";
  city_name: string = "";
  county_name: string = "";
  street_name: string = "";
  detail_info: string = "";
  created_at?: number;
}

export class MemberBan {
  id?: number;
  member_id: string = "";
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
}

export class MemberMessage {
  id?: number;
  title: string = "";
  content: string = "";
  weight: number = 1;
  created_at?: number;
}

export class MemberPrizeLog {
  id?: string;
  order_sn: string = "";
  member_id: string = "";
  prize_type:number = 1;
  created_at?: number;
}

export class MemberLuckDrawsLog {
  id?: number;
  order_sn: string = "";
  member_id: string = "";
  total:number = 0;
  stock:number = 0;
  created_at?: number;
}

export class MemberGameAccount {
  member_id: string = "";
  game_id: number = 0;
  account_type: number = 0;
  nickname: string = "";
  game_code: string = "";
  created_at?: number;
}

export class MemberQuest {
  member_id: string = "";
  quest_id: number = 0;
  progress: number = 0;
  complete: number = 0;
  created_at?: number;
}

export class MemberTitle {
  member_id: string = "";
  title_id: number = 0;
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
}

export class MemberVIP {
  member_id: string = "";
  title_id: number = 0;
  order_sn: string = "";
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
}

export class MemberCompetition {
  member_id: string = "";
  game_room_id: string = "";
  order_sn: string = "";
  win: number = 0;
  ranking: number = 0;
  complete_at: number = 0;
  created_at?: number;
}

export class Title {
  id?: number;
  title: string = "";
  day: number = 0;
  default_image: string = "";
  light_image: string = "";
  created_at?: number = 0;
}
