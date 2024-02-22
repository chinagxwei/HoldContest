import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {Member} from "../../../../../../../entity/member";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {BehaviorSubject, debounceTime} from "rxjs";
import {ProductVipService} from "../../../../../../../services/goods/product-vip.service";
import {Product} from "../../../../../../../entity/goods";
import {NzMessageService} from "ng-zorro-antd/message";
import {MemberService} from "../../../../../../../services/member/member.service";

@Component({
  selector: 'app-set-member-vip',
  templateUrl: './set-member-vip.component.html',
  styleUrls: ['./set-member-vip.component.css']
})
export class SetMemberVipComponent implements OnInit, OnChanges {

  @Input()
  currentMember: Member = new Member()

  @Input()
  visible: boolean = false;

  @Output()
  visibleChange = new EventEmitter<boolean>();

  @Output()
  onSubmitAfter = new EventEmitter<{ id: number, vip_id?: number }>();

  validateForm: FormGroup;

  searchChange$ = new BehaviorSubject('');

  searchVipDataList: Product[] = [];

  isSearchLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private componentService: MemberService,
    private productVipService: ProductVipService) {
    this.validateForm = this.formBuilder.group({
      id: [null, [Validators.required]],
      vip_id: [null, [Validators.required]]
    });
  }

  ngOnInit(): void {
    this.initSearch()
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.validateForm = this.formBuilder.group({
      id: [this.currentMember.id, [Validators.required]],
      vip_id: [null, [Validators.required]]
    });
  }

  handleCancel() {
    this.handleVisible(false);
  }

  handleVisible(type: boolean) {
    this.visible = type;
    this.visibleChange.emit(this.visible)
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
        this.productVipService
          .items(1, {title: v})
          .subscribe((res) => {
            this.searchVipDataList = res.data.data;
            this.isSearchLoading = false;
          })
      });
  }

  handleSave() {
    if (this.validateForm.valid) {

      this.componentService.setVIP(this.validateForm.value).subscribe(res => {
        console.log(res);
        this.onSubmitAfter.emit(this.validateForm.value)

        if (res.code === 200) {
          this.validateForm.reset();
          this.message.success(res.message);
        } else {
          this.message.error(res.message);
        }

        this.handleCancel();
      })

    } else {
      Object.values(this.validateForm.controls).forEach(control => {

        if (control.invalid) {

          control.markAsDirty();

          control.updateValueAndValidity({onlySelf: true});
        }
      });
    }
  }
}
