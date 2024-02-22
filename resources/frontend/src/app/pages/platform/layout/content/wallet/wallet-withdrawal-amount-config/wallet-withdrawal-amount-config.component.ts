import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {WalletWithdrawalAmountConfig} from "../../../../../../entity/wallet";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {
  WalletWithdrawalAmountConfigService
} from "../../../../../../services/wallet/wallet-withdrawal-amount-config.service";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {Unit} from "../../../../../../entity/system";
import {BehaviorSubject, debounceTime} from "rxjs";
import {UnitService} from "../../../../../../services/system/unit.service";

@Component({
  selector: 'app-wallet-withdrawal-amount-config',
  templateUrl: './wallet-withdrawal-amount-config.component.html',
  styleUrls: ['./wallet-withdrawal-amount-config.component.css']
})
export class WalletWithdrawalAmountConfigComponent implements OnInit {

  currentData: Paginate<WalletWithdrawalAmountConfig> = new Paginate<WalletWithdrawalAmountConfig>();

  loading = true;

  listOfData: WalletWithdrawalAmountConfig[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: WalletWithdrawalAmountConfigService
  ) {
    this.validateForm = this.formBuilder.group({});
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
      amount: [null],
      vip_amount: [null],
      unit_id: [null],
      show: [null],
    });
  }

  update(data: WalletWithdrawalAmountConfig) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      amount: [data.amount],
      vip_amount: [data.vip_amount],
      unit_id: [data.unit_id],
      show: [data.show],
    });
    this.showModal()
  }

  onDelete($event: WalletWithdrawalAmountConfig) {

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
