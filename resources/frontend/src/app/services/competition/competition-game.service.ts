import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {CompetitionGame} from "../../entity/competition";
import {
  COMPETITION_GAME_DELETE,
  COMPETITION_GAME_LIST,
  COMPETITION_GAME_SAVE,
  COMPETITION_GAME_VIEW
} from "../../config/competition.url";

@Injectable({
  providedIn: 'root'
})
export class CompetitionGameService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<CompetitionGame>>(`${COMPETITION_GAME_LIST}?page=${page}`)
  }

  public save(postData: CompetitionGame) {
    return this.http.httpPost(COMPETITION_GAME_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<CompetitionGame>(COMPETITION_GAME_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(COMPETITION_GAME_DELETE, {id})
  }
}
