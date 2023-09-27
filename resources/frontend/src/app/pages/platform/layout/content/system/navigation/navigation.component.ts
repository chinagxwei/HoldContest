import { Component, OnInit } from '@angular/core';
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NavigationService} from "../../../../../../services/system/navigation.service";
import {tap} from "rxjs/operators";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {CdkDragDrop, moveItemInArray} from "@angular/cdk/drag-drop";
import {Paginate} from "../../../../../../entity/server-response";
import {Navigation} from "../../../../../../entity/system";

@Component({
  selector: 'app-navigation',
  templateUrl: './navigation.component.html',
  styleUrls: ['./navigation.component.css']
})
export class NavigationComponent implements OnInit {


  currentData: Paginate<Navigation> = new Paginate<Navigation>();

  loading = true;

  listOfData: Navigation[] = [];

  isVisible = false;

  // @ts-ignore
  validateForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private navigationService: NavigationService
  ) {
  }

  ngOnInit(): void {
    this.initForm();
    this.getItems();
  }

  initForm() {
    this.validateForm = this.formBuilder.group({
      navigation_name: [null, [Validators.required]],
      navigation_link: [null, [Validators.required]],
      navigation_router: [null, [Validators.required]],
      icon: [null],
    });
  }

  onQueryParamsChange(params: NzTableQueryParams): void {
    this.getItems(params.pageIndex)
  }

  getItems(page: number = 1) {
    this.loading = true;
    this.navigationService.items(page)
      .pipe(tap(_ => this.loading = false))
      .subscribe(res => {
        const {data} = res;
        if (data) {
          this.currentData = data;
          this.listOfData = data.data;
        }
      })
  }

  update(data: Navigation) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      navigation_name: [data.navigation_name, [Validators.required]],
      navigation_link: [data.navigation_link, [Validators.required]],
      navigation_router: [data.navigation_router, [Validators.required]],
      icon: [data.icon],
    });
    this.showModal()
  }

  onDelete($event: Navigation) {

    this.modalService.confirm({
      nzTitle: '删除提示',
      nzContent: '<b style="color: red;">是否删除该项数据!</b>',
      nzOkText: '确定',
      nzCancelText: '取消',
      nzOnOk: () => {
        this.navigationService.delete($event.id).subscribe(res => {
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
      this.navigationService.save(this.validateForm.value).subscribe(res => {
        console.log(res);
        if (res.code === 0) {
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

  dropNav($event: CdkDragDrop<any[]>) {
    moveItemInArray(this.currentData.data, $event.previousIndex, $event.currentIndex);
    this.currentData.data.map((v, i) => v.navigation_sort = i);
    const newSort = this.currentData.data.map(v => {
      return {id: v.id, sort: v.navigation_sort}
    });
    // @ts-ignore
    this.navigationService.sort(newSort).subscribe(res => {
      console.log(res);
    })
  }
}
