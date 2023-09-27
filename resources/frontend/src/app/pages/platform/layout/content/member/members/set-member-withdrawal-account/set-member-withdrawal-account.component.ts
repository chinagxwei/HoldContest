import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {Member} from "../../../../../../../entity/member";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {WalletWithdrawalAccountService} from "../../../../../../../services/wallet/wallet-withdrawal-account.service";

@Component({
  selector: 'app-set-member-withdrawal-account',
  templateUrl: './set-member-withdrawal-account.component.html',
  styleUrls: ['./set-member-withdrawal-account.component.css']
})
export class SetMemberWithdrawalAccountComponent implements OnInit, OnChanges {

  @Input()
  currentMember: Member = new Member()

  @Input()
  visible: boolean = false;

  @Output()
  visibleChange = new EventEmitter<boolean>();

  @Output()
  onSubmitAfter = new EventEmitter<{ id: number, vip_id?: number }>();

  validateForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private componentService: WalletWithdrawalAccountService
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.validateForm = this.formBuilder.group({
      member_id: [this.currentMember.id, [Validators.required]],
      account_type: ['1', [Validators.required]],
      contact: [null, [Validators.required]],
      mobile: [null, [Validators.required]],
      account: [null, [Validators.required]],
      bank_name: [null]
    });
  }

  handleCancel() {
    this.handleVisible(false);
  }

  handleVisible(type: boolean) {
    this.visible = type;
    this.visibleChange.emit(this.visible)
  }

  handleSave() {
    if (this.validateForm.valid) {
      this.componentService.save(this.validateForm.value).subscribe(res => {
        this.onSubmitAfter.emit(this.validateForm.value)
        console.log(res);
        if (res.code === 200) {
          this.message.success(res.message);
          this.validateForm.reset();
        }else{
          this.message.error(res.message);
        }
        this.handleCancel();
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
