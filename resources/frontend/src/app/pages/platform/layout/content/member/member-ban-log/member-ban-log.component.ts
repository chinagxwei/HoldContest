import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {MemberBan} from "../../../../../../entity/member";
import {MemberBanService} from "../../../../../../services/member/member-ban.service";

@Component({
  selector: 'app-member-ban-log',
  templateUrl: './member-ban-log.component.html',
  styleUrls: ['./member-ban-log.component.css']
})
export class MemberBanLogComponent implements OnInit {


  currentData: Paginate<MemberBan> = new Paginate<MemberBan>();

  loading = true;

  listOfData: MemberBan[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: MemberBanService
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
      member_id: [null, [Validators.required]],
      cycle: [null],
      started_at: [null],
      ended_at: [null],
    });
  }

  update(data: MemberBan) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      member_id: [data.member_id, [Validators.required]],
      started_at: [data.started_at],
      ended_at: [data.ended_at],
      cycle: [null],
    });
    this.showModal()
  }

  onDelete($event: MemberBan) {

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
