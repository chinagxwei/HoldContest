import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {LuckyDrawsConfig} from "../../entity/activity";
import {
  LUCKY_DRAWS_CONFIG_DELETE,
  LUCKY_DRAWS_CONFIG_LIST,
  LUCKY_DRAWS_CONFIG_SAVE,
  LUCKY_DRAWS_CONFIG_VIEW
} from "../../config/activity.url";

@Injectable({
  providedIn: 'root'
})
export class LuckyDrawsConfigService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<LuckyDrawsConfig>>(`${LUCKY_DRAWS_CONFIG_LIST}?page=${page}`)
  }

  public save(postData: LuckyDrawsConfig) {
    return this.http.httpPost(LUCKY_DRAWS_CONFIG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<LuckyDrawsConfig>(LUCKY_DRAWS_CONFIG_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(LUCKY_DRAWS_CONFIG_DELETE, {id})
  }
}
