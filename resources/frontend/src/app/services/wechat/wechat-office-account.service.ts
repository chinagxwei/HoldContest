import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WechatOfficeAccount} from "../../entity/wechat";
import {
  WECHAT_OFFICE_ACCOUNT_DELETE,
  WECHAT_OFFICE_ACCOUNT_LIST,
  WECHAT_OFFICE_ACCOUNT_VIEW
} from "../../config/wchat.url";

@Injectable({
  providedIn: 'root'
})
export class WechatOfficeAccountService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WechatOfficeAccount>>(`${WECHAT_OFFICE_ACCOUNT_LIST}?page=${page}`)
  }

  public view(id: number) {
    return this.http.httpPost<WechatOfficeAccount>(WECHAT_OFFICE_ACCOUNT_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(WECHAT_OFFICE_ACCOUNT_DELETE, {id})
  }
}
