import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {ProductRecharge, ProductVIP} from "../../entity/goods";
import {
  PRODUCT_RECHARGE_DELETE,
  PRODUCT_RECHARGE_LIST,
  PRODUCT_RECHARGE_SAVE,
  PRODUCT_RECHARGE_VIEW
} from "../../config/goods.url";

@Injectable({
  providedIn: 'root'
})
export class ProductRechargeService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: { title: string }) {
    return this.http.httpPost<Paginate<ProductRecharge>>(`${PRODUCT_RECHARGE_LIST}?page=${page}`, query)
  }

  public save(postData: ProductRecharge) {
    return this.http.httpPost(PRODUCT_RECHARGE_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<ProductRecharge>(PRODUCT_RECHARGE_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(PRODUCT_RECHARGE_DELETE, {id})
  }
}
