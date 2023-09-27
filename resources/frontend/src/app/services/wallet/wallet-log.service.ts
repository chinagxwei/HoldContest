import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WalletLog} from "../../entity/wallet";
import {WALLET_LOG_DELETE, WALLET_LOG_LIST, WALLET_LOG_SAVE, WALLET_LOG_VIEW} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletLogService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WalletLog>>(`${WALLET_LOG_LIST}?page=${page}`)
  }

  public save(postData: WalletLog) {
    return this.http.httpPost(WALLET_LOG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<WalletLog>(WALLET_LOG_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(WALLET_LOG_DELETE, {id})
  }
}
