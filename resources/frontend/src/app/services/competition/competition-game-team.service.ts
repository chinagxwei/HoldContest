import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {CompetitionGameTeam} from "../../entity/competition";
import {
  COMPETITION_GAME_TEAM_DELETE,
  COMPETITION_GAME_TEAM_LIST,
  COMPETITION_GAME_TEAM_SAVE,
  COMPETITION_GAME_TEAM_VIEW
} from "../../config/competition.url";

@Injectable({
  providedIn: 'root'
})
export class CompetitionGameTeamService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<CompetitionGameTeam>>(`${COMPETITION_GAME_TEAM_LIST}?page=${page}`)
  }

  public save(postData: CompetitionGameTeam) {
    return this.http.httpPost(COMPETITION_GAME_TEAM_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<CompetitionGameTeam>(COMPETITION_GAME_TEAM_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(COMPETITION_GAME_TEAM_DELETE, {id})
  }
}
