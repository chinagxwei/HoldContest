import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {SystemBanner, SystemImage} from "../../../../../../entity/system";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {ImageService} from "../../../../../../services/system/image.service";
import {tap} from "rxjs/operators";
import {BannerService} from "../../../../../../services/system/banner.service";
import {NzTableQueryParams} from "ng-zorro-antd/table";

@Component({
  selector: 'app-banner',
  templateUrl: './banner.component.html',
  styleUrls: ['./banner.component.css']
})
export class BannerComponent implements OnInit {

  currentData: Paginate<SystemBanner> = new Paginate<SystemBanner>();

  loading = true;

  listOfData: SystemBanner[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: BannerService
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
      url: [null, [Validators.required]],
      position: [null],
      show: [null],
      sort_order: [null],
    });
  }

  add() {
    this.initForm();
    this.isVisible = true;
  }

  update(data: SystemBanner) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      url: [data.url, [Validators.required]],
      position: [data.position],
      show: [data.show],
      sort_order: [data.sort_order],
    });
    this.isVisible = true;
  }

  onDelete($event: SystemImage) {

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
