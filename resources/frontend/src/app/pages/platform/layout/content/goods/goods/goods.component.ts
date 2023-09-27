import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {Goods, Product} from "../../../../../../entity/goods";
import {GoodsService} from "../../../../../../services/goods/goods.service";
import {BehaviorSubject, debounceTime} from "rxjs";
import {Unit} from "../../../../../../entity/system";
import {ProductVipService} from "../../../../../../services/goods/product-vip.service";
import {ProductRechargeService} from "../../../../../../services/goods/product-recharge.service";

@Component({
  selector: 'app-goods',
  templateUrl: './goods.component.html',
  styleUrls: ['./goods.component.css']
})
export class GoodsComponent implements OnInit {


  currentData: Paginate<Goods> = new Paginate<Goods>();

  loading = true;

  listOfData: Goods[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  searchChange$ = new BehaviorSubject('');

  searchDataList: Product[] = [];

  isSearchLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: GoodsService,
    private productVipService: ProductVipService,
    private productRechargeService: ProductRechargeService,
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
    this.getItems();
    // this.initSearch();
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
      description: [null],
      goods_type: ['1', [Validators.required]],
      stock: [1, [Validators.required]],
      status: [0],
      bind: [0],
      started_at: [null],
      ended_at: [null],
      remark: [null],
      cycle: [null],
    });
  }

  update(data: Goods) {

    let obj = {
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      description: [data.description],
      goods_type: [data.goods_type.toString(), [Validators.required]],
      stock: [data.stock, [Validators.required]],
      relation_category: [data?.relation_category],
      relation_id: [data?.relation_category],
      status: [data.status],
      bind: [data.bind],
      started_at: [data.started_at],
      ended_at: [data.ended_at],
      remark: [data.remark],
      cycle: [null],
      relation_name: [null],
    }

    if (data?.relation_category === 1){
      // @ts-ignore
      obj.relation_name = [data.vip?.title];
    }else if (data?.relation_category === 2){
      // @ts-ignore
      obj.relation_name = [data.recharge?.title];
    }else {
      obj.relation_name = [null];
    }

    this.validateForm = this.formBuilder.group(obj);
    if (data.goods_type === 2) {
      this.initRelationProductForm()

    }
    this.initSearch()
    this.showModal()
  }

  initRelationProductForm() {
    let {value} = this.validateForm;
    if (this.validateForm.value.goods_type.toString() === '2') {
      value.relation_category = ['1', [Validators.required]];
      value.relation_id = [null, [Validators.required]];
    } else {
      value.relation_category = [null];
      value.relation_id = [null];
    }

    this.validateForm = this.formBuilder.group(value);

  }

  onDelete($event: Goods) {

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
    // this.validateForm.reset();
    this.initForm();
    this.initSearch()
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
        if (this.validateForm?.value?.relation_category?.toString() === '1') {
          console.log('VIP')
          this.productVipService.items(1,{title: v})
            .subscribe((res) => {
              this.searchDataList = res.data.data;
              this.isSearchLoading = false;
            })
        }else if(this.validateForm?.value?.relation_category?.toString() === '2'){
          console.log('充值')
          this.productRechargeService.items(1,{title: v})
            .subscribe((res) => {
              this.searchDataList = res.data.data;
              this.isSearchLoading = false;
            })
        }
      });
  }

  onChangeGoodsType($event: number) {
    this.initRelationProductForm();
  }
}
