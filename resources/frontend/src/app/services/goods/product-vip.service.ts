import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {ProductVIP} from "../../entity/goods";
import {PRODUCT_VIP_DELETE, PRODUCT_VIP_LIST, PRODUCT_VIP_SAVE, PRODUCT_VIP_VIEW} from "../../config/goods.url";

@Injectable({
  providedIn: 'root'
})
export class ProductVipService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<ProductVIP>>(`${PRODUCT_VIP_LIST}?page=${page}`)
  }

  public save(postData: ProductVIP) {
    return this.http.httpPost(PRODUCT_VIP_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<ProductVIP>(PRODUCT_VIP_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(PRODUCT_VIP_DELETE, {id})
  }
}
