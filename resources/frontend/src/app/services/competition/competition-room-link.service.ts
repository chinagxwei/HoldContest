import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {CompetitionRoom, CompetitionRoomLink, QuickAddCompetitionRoom} from "../../entity/competition";
import {Paginate} from "../../entity/server-response";
import {
  COMPETITION_GAME_ROOM_LINK_AVAILABLE_NUMBER,
  COMPETITION_GAME_ROOM_LINK_DELETE, COMPETITION_GAME_ROOM_LINK_LAST_ROOM_CODE,
  COMPETITION_GAME_ROOM_LINK_LIST, COMPETITION_GAME_ROOM_LINK_QUICK_ADD

} from "../../config/competition.url";

@Injectable({
  providedIn: 'root'
})
export class CompetitionRoomLinkService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<CompetitionRoom>>(`${COMPETITION_GAME_ROOM_LINK_LIST}?page=${page}`)
  }

  public quickAdd(postData: { game_id: number, urls: string[] }) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_LINK_QUICK_ADD, postData)
  }

  public availableNumber(competition_rule_id: number | undefined) {
    return this.http.httpPost<{ count: number }>(COMPETITION_GAME_ROOM_LINK_AVAILABLE_NUMBER, {competition_rule_id})
  }

  public lastRoomCode(competition_rule_id: number | undefined) {
    return this.http.httpPost<{ game_room_code: string }>(COMPETITION_GAME_ROOM_LINK_LAST_ROOM_CODE, {competition_rule_id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_LINK_DELETE, {id})
  }
}
