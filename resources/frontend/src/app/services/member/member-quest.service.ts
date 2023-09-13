import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {MemberQuest} from "../../entity/member";
import {MEMBER_QUEST_DELETE, MEMBER_QUEST_LIST, MEMBER_QUEST_SAVE, MEMBER_QUEST_VIEW} from "../../config/member.url";

@Injectable({
  providedIn: 'root'
})
export class MemberQuestService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<MemberQuest>>(`${MEMBER_QUEST_LIST}?page=${page}`)
  }

  public save(postData: MemberQuest) {
    return this.http.httpPost(MEMBER_QUEST_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<MemberQuest>(MEMBER_QUEST_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(MEMBER_QUEST_DELETE, {id})
  }
}
