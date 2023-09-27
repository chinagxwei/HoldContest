import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {MemberMessage} from "../../entity/member";
import {
  MEMBER_MESSAGE_DELETE,
  MEMBER_MESSAGE_LIST,
  MEMBER_MESSAGE_SAVE,
  MEMBER_MESSAGE_VIEW
} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberMessageService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<MemberMessage>>(`${MEMBER_MESSAGE_LIST}?page=${page}`)
  }

  public save(postData: MemberMessage) {
    return this.http.httpPost(MEMBER_MESSAGE_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberMessage>(MEMBER_MESSAGE_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(MEMBER_MESSAGE_DELETE, {id})
  }
}
