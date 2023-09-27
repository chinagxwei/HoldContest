import {Wallet} from "./wallet";
import {Order} from "./order";
import {Goods} from "./goods";
import {Quest} from "./activity";
import {CompetitionGame, CompetitionRoom} from "./competition";

export class Member {
  id?: string;
  wallet_id: string = "";
  order_income_config_id: string = "";
  nickname: string = "";
  remark: string = "";
  parent_id?: string = "";
  belong_agent_node: string = "";
  mobile: string = "";
  promotion_sn: string = "";
  develop?: number;
  register_type?: number;
  created_at?: number;
  vip_info?: { started_at: number; ended_at: number };
  ban_info?: { started_at: number; ended_at: number };
  wallet: Wallet = new Wallet();
  parent?: Member;
  games?: CompetitionGame[] = [];
}

export class MemberAddress {
  id?: number;
  member_id: string = "";
  default?: number;
  contact: string = "";
  mobile: string = "";
  province_name: string = "";
  city_name: string = "";
  county_name: string = "";
  street_name: string = "";
  detail_info: string = "";
  created_at?: number;
  member?: Member;
}

export class MemberBan {
  id?: number;
  member_id: string = "";
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
  member?: Member;
}

export class MemberMessage {
  id?: number;
  title: string = "";
  content: string = "";
  weight: number = 1;
  status: number = 0;
  created_at?: number;
}

export class MemberPrizeLog {
  id?: string;
  order_sn: string = "";
  member_id: string = "";
  prize_type: number = 1;
  created_at?: number;
  order?: Order;
  member?: Member;
}

export class MemberLuckDrawsLog {
  id?: number;
  order_sn: string = "";
  member_id: string = "";
  total: number = 0;
  stock: number = 0;
  created_at?: number;
  order?: Order;
  member?: Member;
}

export class MemberGameAccount {
  member_id: string = "";
  game_id: number = 0;
  account_type: number = 0;
  nickname: string = "";
  game_code: string = "";
  created_at?: number;
  member?: Member;
  goods?: Goods;
}

export class MemberQuest {
  member_id: string = "";
  quest_id: number = 0;
  progress: number = 0;
  complete?: number;
  created_at?: number;
  member?: Member;
  quest?: Quest;
}

export class MemberTitle {
  member_id: string = "";
  title_id: number = 0;
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
  member?: Member;
  title?: Title;
}

export class MemberVIP {
  member_id: string = "";
  title_id: number = 0;
  order_sn: string = "";
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
  order?: Order;
  member?: Member;
}

export class MemberCompetition {
  id?: number;
  member_id: string = "";
  game_room_id: string = "";
  order_sn: string = "";
  from_order_sn: string = "";
  win: number = 0;
  ranking: number = 0;
  complete_at: number = 0;
  created_at?: number;
  order?: Order;
  from_order?: Order;
  member: Member = new Member();
  room: CompetitionRoom = new CompetitionRoom();
}

export class Title {
  id?: number;
  title: string = "";
  day: number = 0;
  default_image: string = "";
  light_image: string = "";
  created_at?: number = 0;
}
