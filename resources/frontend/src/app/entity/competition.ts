import {Member, MemberCompetition} from "./member";
import {Goods} from "./goods";
import {Unit} from "./system";

type GameAccount = {
  account_type: number,
  nickname: string,
  game_code: string
}

export class CompetitionGame {
  id?: number;
  parent_id?: number;
  game_name: string = "";
  description?: string = "";
  remark?: string = "";
  show?: number = 0;
  created_at?: number;
  rules?: CompetitionRule[]
  game_account?: GameAccount
  parent?: CompetitionGame;
  children?: CompetitionGame[];
}

export class CompetitionRule {
  id?: number;
  title: string = "";
  game_id: number = 0;
  team_game?: number;
  quick?: number;
  participants_price: number = 0;
  unit_id: number = 0;
  participants_number: number = 0;
  daily_participation_limit: number = 0;
  default_start_second: number = 0;
  default_end_second: number = 0;
  start_number: number = 0;
  rule: string = "";
  description: string = "";
  remark: string = "";
  status?: number;
  created_at?: number;
  competition_game?: CompetitionGame;
  prizes?: CompetitionRulePrize[];
  unit?: Unit
}

export class CompetitionRulePrize {
  competition_rule_id: number = 0;
  ranking: number = 0;
  goods_id?: number;
  goods?: Goods;
  competition_rule?: CompetitionRule
}

export class CompetitionGameTeam {
  id?: number;
  title: string = "";
  member_id?: string = "";
  created_at?: number;
  member?: Member;
}

export class CompetitionRoom {
  id?: string;
  competition_rule_id?: number = 0;
  game_room_name: string = "";
  game_room_code: number = 0;
  status?: number;
  quick?: number;
  complete?: number;
  game_room_qrcode?: string = "";
  interval: number = 0;
  link: string = "";
  link_hash: string = "";
  ready_at: number = 0;
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
  competition_rule?: CompetitionRule
  competition_link?: CompetitionRoomLink
  participants: MemberCompetition[] = []
}

export class QuickAddCompetitionRoom {
  interval: number = 0;
  started_at: number = 0;
}

export class CompetitionRoomLink {
  id?: number;
  room_id: number = 0;
  game_id: number = 0;
  link: string = "";
  md5: string = "";
  created_at?: number;
  competition_room?: CompetitionRoom
  competition_game?: CompetitionGame
}
