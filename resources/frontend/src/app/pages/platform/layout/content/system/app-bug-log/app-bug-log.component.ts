import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {SystemImage} from "../../../../../../entity/system";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {ImageService} from "../../../../../../services/system/image.service";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {AppBugLogService} from "../../../../../../services/app/app-bug-log.service";
import {AppBugLog} from "../../../../../../entity/app";

@Component({
  selector: 'app-app-bug-log',
  templateUrl: './app-bug-log.component.html',
  styleUrls: ['./app-bug-log.component.css']
})
export class AppBugLogComponent implements OnInit {


  currentData: Paginate<AppBugLog> = new Paginate<AppBugLog>();

  loading = true;

  listOfData: AppBugLog[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: AppBugLogService
  ) { }

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
      device: [null, [Validators.required]],
      app_version: [null],
      app_version_code: [null, [Validators.required]],
    });
  }

  update(data: AppBugLog) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      device: [data.device, [Validators.required]],
      app_version: [data.app_version, [Validators.required]],
      app_version_code: [data.app_version_code, [Validators.required]],
    });
    this.showModal()
  }

  onDelete($event: AppBugLog) {

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
