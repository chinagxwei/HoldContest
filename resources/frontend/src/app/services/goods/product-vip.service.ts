import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {ProductVip} from "../../entity/goods";
import {PRODUCT_VIP_DELETE, PRODUCT_VIP_LIST, PRODUCT_VIP_SAVE, PRODUCT_VIP_VIEW} from "../../config/goods.url";

@Injectable({
  providedIn: 'root'
})
export class ProductVipService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<ProductVip>>(`${PRODUCT_VIP_LIST}?page=${page}`)
  }

  public save(postData: ProductVip) {
    return this.http.httpPost(PRODUCT_VIP_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<ProductVip>(PRODUCT_VIP_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(PRODUCT_VIP_DELETE, {id})
  }
}
