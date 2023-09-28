import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {LuckyDrawsConfig} from "../../../../../../entity/activity";
import {LuckyDrawsConfigService} from "../../../../../../services/activity/lucky-draws-config.service";

@Component({
  selector: 'app-lucky-draws-config',
  templateUrl: './lucky-draws-config.component.html',
  styleUrls: ['./lucky-draws-config.component.css']
})
export class LuckyDrawsConfigComponent implements OnInit {


  currentData: Paginate<LuckyDrawsConfig> = new Paginate<LuckyDrawsConfig>();

  loading = true;

  listOfData: LuckyDrawsConfig[] = [];

  // @ts-ignore
  validateForm: FormGroup;

  isVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: LuckyDrawsConfigService
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
      total: [null],
      status: [null],
      started_at: [null],
      ended_at: [null],
      cycle: [null]
    });
  }

  update(data: LuckyDrawsConfig) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      total: [data.total],
      status: [data.status],
      started_at: [data.started_at],
      ended_at: [data.ended_at],
      cycle: [null]
    });
    this.showModal()
  }

  onDelete($event: LuckyDrawsConfig) {

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
