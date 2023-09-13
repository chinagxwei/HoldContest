import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WechatMiniProgramAccount, WechatOfficeAccount} from "../../entity/wechat";
import {
  WECHAT_MINI_PROGRAM_DELETE,
  WECHAT_MINI_PROGRAM_LIST, WECHAT_MINI_PROGRAM_VIEW
} from "../../config/wchat.url";

@Injectable({
  providedIn: 'root'
})
export class WechatMiniProgramAccountService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WechatMiniProgramAccount>>(`${WECHAT_MINI_PROGRAM_LIST}?page=${page}`)
  }

  public view(id: number) {
    return this.http.httpPost<WechatMiniProgramAccount>(WECHAT_MINI_PROGRAM_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(WECHAT_MINI_PROGRAM_DELETE, {id})
  }
}
