import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {LuckyDrawsItem} from "../../entity/activity";
import {
  LUCKY_DRAWS_ITEM_DELETE,
  LUCKY_DRAWS_ITEM_LIST,
  LUCKY_DRAWS_ITEM_SAVE,
  LUCKY_DRAWS_ITEM_VIEW
} from "../../config/activity.url";

@Injectable({
  providedIn: 'root'
})
export class LuckyDrawsItemService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<LuckyDrawsItem>>(`${LUCKY_DRAWS_ITEM_LIST}?page=${page}`)
  }

  public save(postData: LuckyDrawsItem) {
    return this.http.httpPost(LUCKY_DRAWS_ITEM_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<LuckyDrawsItem>(LUCKY_DRAWS_ITEM_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(LUCKY_DRAWS_ITEM_DELETE, {id})
  }
}
