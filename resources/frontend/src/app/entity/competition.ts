export class CompetitionGame {
  id?: number;
  team_game: number = 0;
  game_name: string = "";
  quick: number = 0;
  participants_price: string = "";
  participants_number: number = 0;
  start_number: number = 0;
  rule: string = "";
  description: string = "";
  remark: string = "";
  created_at?: number;
}

export class CompetitionGameTeam {
  id?: number;
  title: string = "";
  member_id: string = "";
  created_at?: number;
}

export class CompetitionRoom {
  id?: string;
  game_id: number = 0;
  game_room_name: string = "";
  status: number = 0;
  quick: number = 0;
  complete: number = 0;
  game_room_qrcode: string = "";
  interval: number = 0;
  ready_at: number = 0;
  started_at: number = 0;
  ended_at: number = 0;
  created_at?: number;
}
