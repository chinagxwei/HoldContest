import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {OrderIncomeConfig} from "../../../../../../entity/order";
import {OrderIncomeConfigService} from "../../../../../../services/order/order-income-config.service";

@Component({
  selector: 'app-order-income-config',
  templateUrl: './order-income-config.component.html',
  styleUrls: ['./order-income-config.component.css']
})
export class OrderIncomeConfigComponent implements OnInit {

  currentData: Paginate<OrderIncomeConfig> = new Paginate<OrderIncomeConfig>();

  loading = true;

  listOfData: OrderIncomeConfig[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: OrderIncomeConfigService
  ) {
  }

  ngOnInit(): void {
    this.initForm();
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

  initForm() {
    this.validateForm = this.formBuilder.group({
      title: [null, [Validators.required]],
      vip_commission: [null],
      recharge_commission: [null],
      consume_commission: [null],
      level_1_play_commission: [null],
      level_2_play_commission: [null],
      agent_commission: [null],
      withdraw_point: [null, [Validators.required]],
      vip_withdraw_point: [null, [Validators.required]],
    });
  }

  update(data: OrderIncomeConfig) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data, [Validators.required]],
      vip_commission: [data.vip_commission],
      recharge_commission: [data.recharge_commission],
      consume_commission: [data.consume_commission],
      level_1_play_commission: [data.level_1_play_commission],
      level_2_play_commission: [data.level_2_play_commission],
      agent_commission: [data.agent_commission],
      withdraw_point: [data.withdraw_point, [Validators.required]],
      vip_withdraw_point: [data.vip_withdraw_point, [Validators.required]],
    });
    this.showModal()
  }

  onDelete($event: OrderIncomeConfig) {

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

  add() {
    this.validateForm.reset();
    this.showModal();
  }

  showModal(): void {
    this.isVisible = true;
  }

  handleCancel() {
    this.isVisible = false;
  }

  handleOk() {
    this.submitForm();
  }

  submitForm() {
    if (this.validateForm.valid) {
      this.componentService.save(this.validateForm.value).subscribe(res => {
        console.log(res);
        if (res.code === 200) {
          this.message.success(res.message);
          this.handleCancel();
          this.validateForm.reset();
          this.getItems(this.currentData.current_page);
        }
      });
    } else {
      Object.values(this.validateForm.controls).forEach(control => {
        // @ts-ignore
        if (control.invalid) {
          // @ts-ignore
          control.markAsDirty();
          // @ts-ignore
          control.updateValueAndValidity({onlySelf: true});
        }
      });
    }
  }
}
