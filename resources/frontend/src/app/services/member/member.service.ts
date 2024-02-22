import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Member, Title} from "../../entity/member";
import {
  MEMBER_DELETE, MEMBER_GENERATE,
  MEMBER_LIST, MEMBER_SAVE, MEMBER_SET_GAME_ACCOUNT, MEMBER_SET_RECHARGE, MEMBER_SET_VIP,
  MEMBER_VIEW
} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: Member) {
    return this.http.httpPost<Paginate<Member>>(`${MEMBER_LIST}?page=${page}`, query)
  }

  public save(postData: Member) {
    return this.http.httpPost(MEMBER_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Member>(MEMBER_VIEW, {id})
  }

  public delete(id: string | undefined) {
    return this.http.httpPost(MEMBER_DELETE, {id})
  }

  public generate() {
    return this.http.httpPost(MEMBER_GENERATE)
  }

  public setVIP(postData: { id: number, vip_id: number }) {
    return this.http.httpPost(MEMBER_SET_VIP, postData)
  }

  public setRecharge(postData: { id: number, amount: number, unit_id: number, remark?: string }) {
    return this.http.httpPost(MEMBER_SET_RECHARGE, postData)
  }

  public setGameAccount(postData: {
    member_id: string,
    game_id: number,
    account_type: number,
    nickname: string,
    game_code?: string
  }) {
    return this.http.httpPost(MEMBER_SET_GAME_ACCOUNT, postData)
  }
}
