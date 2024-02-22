import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {SystemBanner} from "../../entity/system";
import {
  BANNER_DELETE,
  BANNER_LISTS,
  BANNER_SAVE,
} from "../../config/system.url";

@Injectable({
  providedIn: 'root'
})
export class BannerService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<SystemBanner>>(`${BANNER_LISTS}?page=${page}`)
  }

  public save(postData: SystemBanner) {
    return this.http.httpPost(BANNER_SAVE, postData)
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(BANNER_DELETE, {id})
  }
}
