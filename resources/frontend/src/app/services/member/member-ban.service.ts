import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {MemberBan} from "../../entity/member";
import {MEMBER_BAN_DELETE, MEMBER_BAN_LIST, MEMBER_BAN_SAVE, MEMBER_BAN_VIEW} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberBanService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<MemberBan>>(`${MEMBER_BAN_LIST}?page=${page}`)
  }

  public save(postData: MemberBan) {
    return this.http.httpPost(MEMBER_BAN_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberBan>(MEMBER_BAN_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(MEMBER_BAN_DELETE, {id})
  }
}
