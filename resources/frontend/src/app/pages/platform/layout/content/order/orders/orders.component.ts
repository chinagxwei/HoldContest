import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {Order} from "../../../../../../entity/order";
import {OrderService} from "../../../../../../services/order/order.service";

@Component({
  selector: 'app-orders',
  templateUrl: './orders.component.html',
  styleUrls: ['./orders.component.css']
})
export class OrdersComponent implements OnInit {


  currentData: Paginate<Order> = new Paginate<Order>();

  loading = true;

  listOfData: Order[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private modalService: NzModalService,
    private componentService: OrderService
  ) {
  }

  trackByIndex(_: number, data: Order) {
    return data.created_at;
  }

  ngOnInit(): void {
    this.getItems();
  }


  onQueryParamsChange($event: NzTableQueryParams) {
    this.getItems($event.pageIndex);
  }

  private getItems(page: number = 1) {
    this.loading = true;
    this.componentService.items(page)
      .pipe(tap(_ => this.loading = false))
      .subscribe(res => {
        const {data} = res;
        if (data) {
          this.currentData = data;
          data.data.map(v => {
            if (v.pay_at) {
              v.pay_at = v.pay_at * 1000;
            }
            if (v.cancel_at) {
              v.cancel_at = v.cancel_at * 1000;
            }
            return v
          })
          this.listOfData = data.data;
        }
      })
  }

  onDelete($event: Order) {

    this.modalService.confirm({
      nzTitle: '删除提示',
      nzContent: '<b style="color: red;">是否删除该项数据!</b>',
      nzOkText: '确定',
      nzCancelText: '取消',
      nzOnOk: () => {
        this.componentService.delete($event.id).subscribe(res => {
          this.getItems(this.currentData.current_page);
        });
      },
      nzOnCancel: () => {
        console.log('Cancel')
      }
    });
  }
}
