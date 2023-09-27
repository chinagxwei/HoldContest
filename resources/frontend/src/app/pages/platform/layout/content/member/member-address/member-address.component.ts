import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {MemberAddress} from "../../../../../../entity/member";
import {MemberAddressService} from "../../../../../../services/member/member-address.service";

@Component({
  selector: 'app-member-address',
  templateUrl: './member-address.component.html',
  styleUrls: ['./member-address.component.css']
})
export class MemberAddressComponent implements OnInit {

  currentData: Paginate<MemberAddress> = new Paginate<MemberAddress>();

  loading = true;

  listOfData: MemberAddress[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: MemberAddressService
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
      member_id: [null, [Validators.required]],
      default: [0],
      contact: [null, [Validators.required]],
      mobile: [null, [Validators.required]],
      province_name: [null],
      city_name: [null],
      county_name: [null],
      street_name: [null],
      detail_info: [null, [Validators.required]],
    });
  }

  update(data: MemberAddress) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      member_id: [data.member_id, [Validators.required]],
      default: [data.default],
      contact: [data.contact, [Validators.required]],
      mobile: [data.mobile, [Validators.required]],
      province_name: [data.province_name],
      city_name: [data.city_name],
      county_name: [data.county_name],
      street_name: [data.street_name],
      detail_info: [data.detail_info, [Validators.required]],
    });
    this.showModal()
  }

  onDelete($event: MemberAddress) {

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
