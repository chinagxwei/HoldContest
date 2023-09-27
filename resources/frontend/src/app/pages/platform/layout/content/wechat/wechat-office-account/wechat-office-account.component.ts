import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {Unit} from "../../../../../../entity/system";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {WechatOfficeAccount} from "../../../../../../entity/wechat";
import {WechatOfficeAccountService} from "../../../../../../services/wechat/wechat-office-account.service";

@Component({
  selector: 'app-wechat-office-account',
  templateUrl: './wechat-office-account.component.html',
  styleUrls: ['./wechat-office-account.component.css']
})
export class WechatOfficeAccountComponent implements OnInit {


  currentData: Paginate<WechatOfficeAccount> = new Paginate<WechatOfficeAccount>();

  loading = true;

  listOfData: WechatOfficeAccount[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private modalService: NzModalService,
    private componentService: WechatOfficeAccountService
  ) {
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
          this.listOfData = data.data;
        }
      })
  }

  onDelete($event: Unit) {

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
