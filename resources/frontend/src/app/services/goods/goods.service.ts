import { Injectable } from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Goods} from "../../entity/goods";
import {GOODS_DELETE, GOODS_LIST, GOODS_SAVE, GOODS_VIEW} from "../../config/goods.url";

@Injectable({
  providedIn: 'root'
})
export class GoodsService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Goods>>(`${GOODS_LIST}?page=${page}`)
  }

  public save(postData: Goods) {
    return this.http.httpPost(GOODS_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Goods>(GOODS_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(GOODS_DELETE, {id})
  }
}
