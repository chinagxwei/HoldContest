import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Order, OrderIncomeConfig} from "../../entity/order";
import {
  ORDER_INCOME_CONFIG_DELETE,
  ORDER_INCOME_CONFIG_LIST,
  ORDER_INCOME_CONFIG_SAVE,
  ORDER_INCOME_CONFIG_VIEW
} from "../../config/order.url";

@Injectable({
  providedIn: 'root'
})
export class OrderIncomeConfigService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1, query?: OrderIncomeConfig) {
    return this.http.httpPost<Paginate<OrderIncomeConfig>>(`${ORDER_INCOME_CONFIG_LIST}?page=${page}`, query)
  }

  public save(postData: OrderIncomeConfig) {
    return this.http.httpPost(ORDER_INCOME_CONFIG_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<OrderIncomeConfig>(ORDER_INCOME_CONFIG_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(ORDER_INCOME_CONFIG_DELETE, {id})
  }
}
