import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {WalletRecharge} from "../../../../../../entity/wallet";
import {WalletRechargeService} from "../../../../../../services/wallet/wallet-recharge.service";

@Component({
  selector: 'app-wallet-recharge',
  templateUrl: './wallet-recharge.component.html',
  styleUrls: ['./wallet-recharge.component.css']
})
export class WalletRechargeComponent implements OnInit {


  currentData: Paginate<WalletRecharge> = new Paginate<WalletRecharge>();

  loading = true;

  listOfData: WalletRecharge[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: WalletRechargeService
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
      denomination: [null, [Validators.required]],
      unit_id: [null, [Validators.required]],
      channel: [null, [Validators.required]],
      gift: [null, [Validators.required]],
    });
  }

  update(data: WalletRecharge) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      balance: [data.balance, [Validators.required]],
      unit_id: [data.unit_id, [Validators.required]],
      channel: [data.channel, [Validators.required]],
      gift: [data.gift, [Validators.required]],
    });
    this.showModal()
  }

  onDelete($event: WalletRecharge) {

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
