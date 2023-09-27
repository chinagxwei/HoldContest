import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WalletWithdrawal} from "../../entity/wallet";
import {
  WALLET_WITHDRAWAL_DELETE,
  WALLET_WITHDRAWAL_LIST,
  WALLET_WITHDRAWAL_SAVE,
  WALLET_WITHDRAWAL_VIEW
} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletWithdrawalService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WalletWithdrawal>>(`${WALLET_WITHDRAWAL_LIST}?page=${page}`)
  }

  public save(postData: WalletWithdrawal) {
    return this.http.httpPost(WALLET_WITHDRAWAL_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<WalletWithdrawal>(WALLET_WITHDRAWAL_VIEW, {id})
  }

  public delete(id: string | undefined) {
    return this.http.httpPost(WALLET_WITHDRAWAL_DELETE, {id})
  }
}
