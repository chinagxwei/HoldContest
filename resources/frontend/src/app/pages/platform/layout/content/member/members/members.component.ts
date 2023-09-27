import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {Member} from "../../../../../../entity/member";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {MemberService} from "../../../../../../services/member/member.service";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";

@Component({
  selector: 'app-members',
  templateUrl: './members.component.html',
  styleUrls: ['./members.component.css']
})
export class MembersComponent implements OnInit {

  currentData: Paginate<Member> = new Paginate<Member>();

  loading = true;

  listOfData: Member[] = [];

  currentMember: Member = new Member()

  validateForm: FormGroup;

  isVisible: boolean = false;

  validateRechargeForm: FormGroup;

  isSearchVisible: boolean = false;

  showSetGameAccount = false;

  showSetWithdrawalAccount = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: MemberService
  ) {
    this.validateForm = this.formBuilder.group({});
    this.validateRechargeForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
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
          data.data.map(v => {
            if (!!v.vip_info) {
              v.vip_info.started_at = v.vip_info?.started_at * 1000;
              v.vip_info.ended_at = v.vip_info?.ended_at * 1000;
            }
            if (!!v.ban_info) {
              v.ban_info.started_at = v.ban_info?.started_at * 1000;
              v.ban_info.ended_at = v.ban_info?.ended_at * 1000;
            }
            return v
          })
          this.listOfData = data.data;
        }
      })
  }

  onDelete($event: Member) {

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
    this.modalService.confirm({
      nzTitle: '提示',
      nzContent: '<b style="color: red;">是否创建测试会员!</b>',
      nzOkText: '确定',
      nzCancelText: '取消',
      nzOnOk: () => {
        this.componentService.generate().subscribe(res => {
          this.getItems(this.currentData.current_page);
        })
      },
      nzOnCancel: () => {
        console.log('Cancel')
      }
    });
  }

  update(data: Member) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      order_income_config_id: [data.order_income_config_id, [Validators.required]],
      remark: [data.remark],
      develop: [data.develop],
      mobile: [data.mobile],
    });
  }

  handleRefresh(){
    this.getItems(this.currentData.current_page);
  }

  // submitForm() {
  //   if (this.validateSearchForm.valid) {
  //     // this.componentService.save(this.validateForm.value).subscribe(res => {
  //     //   console.log(res);
  //     //   if (res.code === 200) {
  //     //     this.message.success(res.message);
  //     //     this.handleCancel();
  //     //     this.validateForm.reset();
  //     //     this.getItems(this.currentData.current_page);
  //     //   }
  //     // });
  //   } else {
  //     Object.values(this.validateSearchForm.controls).forEach(control => {
  //       // @ts-ignore
  //       if (control.invalid) {
  //         // @ts-ignore
  //         control.markAsDirty();
  //         // @ts-ignore
  //         control.updateValueAndValidity({onlySelf: true});
  //       }
  //     });
  //   }
  // }

  giveVIP(data: Member) {
    this.currentMember = data;
    this.isSearchVisible = true;
  }

  giveRecharge(data: Member) {
    this.currentMember = data;
    this.isVisible = true;
  }

  setGameAccount(data: Member) {
    this.currentMember = data;
    this.showSetGameAccount = true;
  }

  setWithdrawalAccount(data: Member) {
    this.currentMember = data;
    this.showSetWithdrawalAccount = true;
  }
}
