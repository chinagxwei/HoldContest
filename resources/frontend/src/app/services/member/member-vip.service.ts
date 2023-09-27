import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {MemberVIP} from "../../entity/member";
import {MEMBER_VIP_DELETE, MEMBER_VIP_LIST, MEMBER_VIP_SAVE, MEMBER_VIP_VIEW} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberVipService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<MemberVIP>>(`${MEMBER_VIP_LIST}?page=${page}`)
  }

  public save(postData: MemberVIP) {
    return this.http.httpPost(MEMBER_VIP_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberVIP>(MEMBER_VIP_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(MEMBER_VIP_DELETE, {id})
  }
}
