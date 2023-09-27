import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {WalletConsume} from "../../entity/wallet";
import {
  WALLET_CONSUME_DELETE,
  WALLET_CONSUME_LIST,
  WALLET_CONSUME_SAVE,
  WALLET_CONSUME_VIEW
} from "../../config/wallet.url";

@Injectable({
  providedIn: 'root'
})
export class WalletConsumeService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<WalletConsume>>(`${WALLET_CONSUME_LIST}?page=${page}`)
  }

  public save(postData: WalletConsume) {
    return this.http.httpPost(WALLET_CONSUME_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<WalletConsume>(WALLET_CONSUME_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(WALLET_CONSUME_DELETE, {id})
  }
}
