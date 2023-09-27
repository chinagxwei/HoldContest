import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {AppPublishLog} from "../../entity/app";
import {
  APP_PUBLISH_LOG_DELETE,
  APP_PUBLISH_LOG_LIST,
  APP_PUBLISH_LOG_SAVE,
  APP_PUBLISH_LOG_VIEW
} from "../../config/app.url";

@Injectable({
  providedIn: 'root'
})
export class AppPublishLogService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: AppPublishLog) {
    return this.http.httpPost<Paginate<AppPublishLog>>(`${APP_PUBLISH_LOG_LIST}?page=${page}`, query)
  }

  public save(postData: AppPublishLog) {
    return this.http.httpPost(APP_PUBLISH_LOG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<AppPublishLog>(APP_PUBLISH_LOG_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(APP_PUBLISH_LOG_DELETE, {id})
  }
}
