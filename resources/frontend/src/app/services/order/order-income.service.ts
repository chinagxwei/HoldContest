import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {OrderIncome} from "../../entity/order";
import {ORDER_INCOME_DELETE, ORDER_INCOME_LIST, ORDER_INCOME_SAVE, ORDER_INCOME_VIEW} from "../../config/order.url";

@Injectable({
  providedIn: 'root'
})
export class OrderIncomeService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<OrderIncome>>(`${ORDER_INCOME_LIST}?page=${page}`)
  }

  public save(postData: OrderIncome) {
    return this.http.httpPost(ORDER_INCOME_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<OrderIncome>(ORDER_INCOME_VIEW, {id})
  }

  public delete(id: number | undefined) {
    return this.http.httpPost(ORDER_INCOME_DELETE, {id})
  }
}
