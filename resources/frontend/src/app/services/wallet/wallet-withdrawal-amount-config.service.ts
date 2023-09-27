import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WalletWithdrawalAmountConfig} from "../../entity/wallet";
import {
  WALLET_WITHDRAWAL_AMOUNT_CONFIG_DELETE,
  WALLET_WITHDRAWAL_AMOUNT_CONFIG_LIST,
  WALLET_WITHDRAWAL_AMOUNT_CONFIG_SAVE,
  WALLET_WITHDRAWAL_AMOUNT_CONFIG_VIEW
} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletWithdrawalAmountConfigService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WalletWithdrawalAmountConfig>>(`${WALLET_WITHDRAWAL_AMOUNT_CONFIG_LIST}?page=${page}`)
  }

  public save(postData: WalletWithdrawalAmountConfig) {
    return this.http.httpPost(WALLET_WITHDRAWAL_AMOUNT_CONFIG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<WalletWithdrawalAmountConfig>(WALLET_WITHDRAWAL_AMOUNT_CONFIG_VIEW, {id})
  }

  public delete(id: string | undefined) {
    return this.http.httpPost(WALLET_WITHDRAWAL_AMOUNT_CONFIG_DELETE, {id})
  }
}
