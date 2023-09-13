import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Wallet} from "../../entity/wallet";
import {WALLET_DELETE, WALLET_LIST, WALLET_SAVE, WALLET_VIEW} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Wallet>>(`${WALLET_LIST}?page=${page}`)
  }

  public save(postData: Wallet) {
    return this.http.httpPost(WALLET_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Wallet>(WALLET_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(WALLET_DELETE, {id})
  }
}
