import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {MemberPrizeLog} from "../../entity/member";
import {
  MEMBER_PRIZE_LOG_DELETE,
  MEMBER_PRIZE_LOG_LIST,
  MEMBER_PRIZE_LOG_SAVE,
  MEMBER_PRIZE_LOG_VIEW
} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberPrizeLogService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<MemberPrizeLog>>(`${MEMBER_PRIZE_LOG_LIST}?page=${page}`)
  }

  public save(postData: MemberPrizeLog) {
    return this.http.httpPost(MEMBER_PRIZE_LOG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberPrizeLog>(MEMBER_PRIZE_LOG_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(MEMBER_PRIZE_LOG_DELETE, {id})
  }
}
