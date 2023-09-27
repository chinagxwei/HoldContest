import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {CompetitionRoom, CompetitionRule, QuickAddCompetitionRoom} from "../../entity/competition";
import {
  COMPETITION_GAME_ROOM_QUICK_ADD,
  COMPETITION_GAME_ROOM_DELETE,
  COMPETITION_GAME_ROOM_LIST,
  COMPETITION_GAME_ROOM_SAVE,
  COMPETITION_GAME_ROOM_VIEW, COMPETITION_GAME_ROOM_SETTLEMENT, COMPETITION_GAME_ROOM_JOIN
} from "../../config/competition.url";

@Injectable({
  providedIn: 'root'
})
export class CompetitionRoomService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: CompetitionRoom | { started_at: number, ready_at: number }) {
    if (query) {
      query.started_at = 0;
      query.ready_at = 0
    } else {
      query = {
        started_at: 0,
        ready_at: 0
      }
    }
    return this.http.httpPost<Paginate<CompetitionRoom>>(`${COMPETITION_GAME_ROOM_LIST}?page=${page}`, query)
  }

  public save(postData: CompetitionRoom) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_SAVE, postData)
  }

  public quickAdd(postData: QuickAddCompetitionRoom) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_QUICK_ADD, postData)
  }

  public view(id: number) {
    return this.http.httpPost<CompetitionRoom>(COMPETITION_GAME_ROOM_VIEW, {id})
  }

  public delete(id: string | undefined) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_DELETE, {id})
  }

  public settlement(id: string | undefined, prizes: {}) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_SETTLEMENT, {id, prizes})
  }

  public join(id: string | undefined, member_id: string) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_JOIN, {id, member_id})
  }
}
