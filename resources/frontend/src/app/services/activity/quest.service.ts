import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Quest} from "../../entity/activity";
import {QUEST_DELETE, QUEST_LIST, QUEST_SAVE, QUEST_VIEW} from "../../config/activity.url";

@Injectable({
  providedIn: 'root'
})
export class QuestService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Quest>>(`${QUEST_LIST}?page=${page}`)
  }

  public save(postData: Quest) {
    return this.http.httpPost(QUEST_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Quest>(QUEST_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(QUEST_DELETE, {id})
  }
}
