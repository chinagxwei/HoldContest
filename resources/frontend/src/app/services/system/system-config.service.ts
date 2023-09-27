import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {
  CONFIG_DELETE,
  CONFIG_ITEMS,
  CONFIG_SAVE
} from "../../config/system.url";
import {Paginate} from "../../entity/server-response";
import {SystemConfig} from "../../entity/system";

@Injectable({
  providedIn: 'root'
})
export class SystemConfigService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<SystemConfig>>(`${CONFIG_ITEMS}?page=${page}`)
  }

  public save(postData: SystemConfig | { key: string, value: string }) {
    return this.http.httpPost(CONFIG_SAVE, postData)
  }

  public delete(id: number) {
    return this.http.httpPost(CONFIG_DELETE, {id})
  }
}
