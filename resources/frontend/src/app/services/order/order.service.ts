import {Injectable} from '@angular/core';
import {HttpReprint} from "../../util/http.reprint";
import {Paginate} from "../../entity/server-response";
import {Order} from "../../entity/order";
import {ORDER_DELETE, ORDER_LIST, ORDER_SAVE, ORDER_VIEW} from "../../config/order.url";

@Injectable({
  providedIn: 'root'
})
export class OrderService {

  constructor(private http: HttpReprint) {
  }

  public items(page: number = 1) {
    return this.http.httpPost<Paginate<Order>>(`${ORDER_LIST}?page=${page}`)
  }

  public save(postData: Order) {
    return this.http.httpPost(ORDER_SAVE, postData)
  }

  public view(id: number) {
    return this.http.httpPost<Order>(ORDER_VIEW, {id})
  }

  public delete(id: number) {
    return this.http.httpPost(ORDER_DELETE, {id})
  }
}
