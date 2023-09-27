import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WalletWithdrawAccount} from "../../entity/wallet";
import {
  WALLET_WITHDRAWAL_ACCOUNT_DELETE,
  WALLET_WITHDRAWAL_ACCOUNT_LIST,
  WALLET_WITHDRAWAL_ACCOUNT_SAVE,
  WALLET_WITHDRAWAL_ACCOUNT_VIEW
} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletWithdrawalAccountService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WalletWithdrawAccount>>(`${WALLET_WITHDRAWAL_ACCOUNT_LIST}?page=${page}`)
  }

  public save(postData: WalletWithdrawAccount) {
    return this.http.httpPost(WALLET_WITHDRAWAL_ACCOUNT_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<WalletWithdrawAccount>(WALLET_WITHDRAWAL_ACCOUNT_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(WALLET_WITHDRAWAL_ACCOUNT_DELETE, {id})
  }
}
