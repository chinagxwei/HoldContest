import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {MemberGameAccount} from "../../entity/member";
import {
  MEMBER_GAME_ACCOUNT_DELETE,
  MEMBER_GAME_ACCOUNT_LIST,
  MEMBER_GAME_ACCOUNT_SAVE,
  MEMBER_GAME_ACCOUNT_VIEW
} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberGameAccountService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<MemberGameAccount>>(`${MEMBER_GAME_ACCOUNT_LIST}?page=${page}`)
  }

  public save(postData: MemberGameAccount) {
    return this.http.httpPost(MEMBER_GAME_ACCOUNT_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberGameAccount>(MEMBER_GAME_ACCOUNT_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(MEMBER_GAME_ACCOUNT_DELETE, {id})
  }
}
