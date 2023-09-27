import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {LuckyDrawsItem} from "../../../../../../entity/activity";
import {LuckyDrawsItemService} from "../../../../../../services/activity/lucky-draws-item.service";
import {BehaviorSubject, debounceTime} from "rxjs";
import {Unit} from "../../../../../../entity/system";
import {GoodsService} from "../../../../../../services/goods/goods.service";
import {Goods} from "../../../../../../entity/goods";

@Component({
  selector: 'app-lucky-draws-item',
  templateUrl: './lucky-draws-item.component.html',
  styleUrls: ['./lucky-draws-item.component.css']
})
export class LuckyDrawsItemComponent implements OnInit {


  currentData: Paginate<LuckyDrawsItem> = new Paginate<LuckyDrawsItem>();

  loading = true;

  listOfData: LuckyDrawsItem[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  searchChange$ = new BehaviorSubject('');

  searchDataList: Goods[] = [];

  isSearchLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: LuckyDrawsItemService,
    private goodsService: GoodsService
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
    this.initForm();
    this.getItems();
    this.initSearch();
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
      image: [null],
      goods_id: [null],
      status: [null],
    });
  }

  update(data: LuckyDrawsItem) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      image: [data.image],
      goods_id: [data.goods_id],
      status: [data.status],
    });
    this.showModal()
  }

  onDelete($event: LuckyDrawsItem) {

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

  onSearch(value: string): void {
    this.isSearchLoading = true;
    this.searchChange$.next(value);
  }

  initSearch() {
    this.searchChange$
      .asObservable()
      .pipe(debounceTime(300))
      .subscribe((v) => {
        const goods = new Goods;
        goods.title = v;
        this.goodsService
          .items(1, goods)
          .subscribe((res) => {
            this.searchDataList = res.data.data;
            this.isSearchLoading = false;
          })
      });
  }
}
