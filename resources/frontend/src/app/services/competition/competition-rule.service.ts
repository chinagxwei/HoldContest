import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {CompetitionGame, CompetitionRule} from "../../entity/competition";
import {
  COMPETITION_RULE_CONFIG_PRIZE,
  COMPETITION_RULE_DELETE, COMPETITION_RULE_LIST, COMPETITION_RULE_SAVE, COMPETITION_RULE_VIEW
} from "../../config/competition.url";

@Injectable({
  providedIn: 'root'
})
export class CompetitionRuleService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: CompetitionRule) {
    return this.http.httpPost<Paginate<CompetitionRule>>(`${COMPETITION_RULE_LIST}?page=${page}`, query)
  }

  public save(postData: CompetitionRule) {
    return this.http.httpPost(COMPETITION_RULE_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<CompetitionRule>(COMPETITION_RULE_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(COMPETITION_RULE_DELETE, {id})
  }

  public configPrize(id: number | undefined, prizes: {}) {
    return this.http.httpPost(COMPETITION_RULE_CONFIG_PRIZE, {id, prizes})
  }
}
