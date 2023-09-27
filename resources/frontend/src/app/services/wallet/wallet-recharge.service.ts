import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WalletRecharge} from "../../entity/wallet";
import {
  WALLET_RECHARGE_DELETE,
  WALLET_RECHARGE_LIST,
  WALLET_RECHARGE_SAVE,
  WALLET_RECHARGE_VIEW
} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletRechargeService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WalletRecharge>>(`${WALLET_RECHARGE_LIST}?page=${page}`)
  }

  public save(postData: WalletRecharge) {
    return this.http.httpPost(WALLET_RECHARGE_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<WalletRecharge>(WALLET_RECHARGE_VIEW, {id})
  }

  public delete(id: string | undefined) {
    return this.http.httpPost(WALLET_RECHARGE_DELETE, {id})
  }
}
