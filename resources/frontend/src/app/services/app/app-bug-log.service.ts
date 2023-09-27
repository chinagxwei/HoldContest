import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {AppBugLog} from "../../entity/app";
import {APP_BUG_LOG_DELETE, APP_BUG_LOG_LIST, APP_BUG_LOG_SAVE, APP_BUG_LOG_VIEW} from "../../config/app.url";

@Injectable({
  providedIn: 'root'
})
export class AppBugLogService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: AppBugLog) {
    return this.http.httpPost<Paginate<AppBugLog>>(`${APP_BUG_LOG_LIST}?page=${page}`, query)
  }

  public save(postData: AppBugLog) {
    return this.http.httpPost(APP_BUG_LOG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<AppBugLog>(APP_BUG_LOG_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(APP_BUG_LOG_DELETE, {id})
  }
}
