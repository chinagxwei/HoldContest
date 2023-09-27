import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {CompetitionRoom} from "../../entity/competition";
import {
  COMPETITION_GAME_ROOM_DELETE,
  COMPETITION_GAME_ROOM_LIST,
  COMPETITION_GAME_ROOM_SAVE,
  COMPETITION_GAME_ROOM_VIEW
} from "../../config/competition.url";

@Injectable({
  providedIn: 'root'
})
export class CompetitionRoomService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<CompetitionRoom>>(`${COMPETITION_GAME_ROOM_LIST}?page=${page}`)
  }

  public save(postData: CompetitionRoom) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<CompetitionRoom>(COMPETITION_GAME_ROOM_VIEW, {id})
  }

  public delete(id: string | undefined) {
    return this.http.httpPost(COMPETITION_GAME_ROOM_DELETE, {id})
  }
}
