import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {Unit} from "../../../../../../entity/system";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {UnitService} from "../../../../../../services/system/unit.service";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {MemberPrizeLog} from "../../../../../../entity/member";
import {MemberPrizeLogService} from "../../../../../../services/member/member-prize-log.service";

@Component({
  selector: 'app-member-prize-log',
  templateUrl: './member-prize-log.component.html',
  styleUrls: ['./member-prize-log.component.css']
})
export class MemberPrizeLogComponent implements OnInit {


  currentData: Paginate<MemberPrizeLog> = new Paginate<MemberPrizeLog>();

  loading = true;

  listOfData: MemberPrizeLog[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: MemberPrizeLogService
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
      order_sn: [null, [Validators.required]],
      member_id: [null, [Validators.required]],
      prize_type: [null],
    });
  }

  update(data: MemberPrizeLog) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      order_sn: [data.order_sn, [Validators.required]],
      member_id: [data.member_id, [Validators.required]],
      prize_type: [data.prize_type],
    });
    this.showModal()
  }

  onDelete($event: MemberPrizeLog) {

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
