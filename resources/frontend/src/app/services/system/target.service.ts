import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Target} from "../../entity/system";
import {
  TARGET_DELETE,
  TARGET_LIST,
  TARGET_SAVE,
  TARGET_VIEW,
} from "../../config/system.url";

@Injectable({
  providedIn: 'root'
})
export class TargetService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: Target) {
    return this.http.httpPost<Paginate<Target>>(`${TARGET_LIST}?page=${page}`, query)
  }

  public save(postData: Target) {
    return this.http.httpPost(TARGET_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Target>(TARGET_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(TARGET_DELETE, {id})
  }
}
