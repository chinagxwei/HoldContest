import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {Member} from "../../../../../../../entity/member";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {MemberService} from "../../../../../../../services/member/member.service";

@Component({
  selector: 'app-set-member-recharge',
  templateUrl: './set-member-recharge.component.html',
  styleUrls: ['./set-member-recharge.component.css']
})
export class SetMemberRechargeComponent implements OnInit, OnChanges {

  @Input()
  currentMember: Member = new Member()

  @Input()
  visible: boolean = false;

  @Output()
  visibleChange = new EventEmitter<boolean>();

  @Output()
  onSubmitAfter = new EventEmitter<any>();

  validateForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private componentService: MemberService
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.validateForm = this.formBuilder.group({
      id: [this.currentMember.id, [Validators.required]],
      amount: [0, [Validators.required]],
      unit_id: [null, [Validators.required]],
      remark: [null]
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

      this.componentService.setRecharge(this.validateForm.value).subscribe(res => {
        this.onSubmitAfter.emit(this.validateForm.value)
        console.log(res);
        if (res.code === 200) {
          this.message.success(res.message);

          this.validateForm.reset();

          this.handleCancel();
        } else {
          this.message.error(res.message);
        }
      })
      
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
