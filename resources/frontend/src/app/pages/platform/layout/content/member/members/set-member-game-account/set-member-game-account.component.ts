import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {Member} from "../../../../../../../entity/member";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {MemberService} from "../../../../../../../services/member/member.service";

@Component({
  selector: 'app-set-member-game-account',
  templateUrl: './set-member-game-account.component.html',
  styleUrls: ['./set-member-game-account.component.css']
})
export class SetMemberGameAccountComponent implements OnInit, OnChanges {

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
      game_id: [null, [Validators.required]],
      account_type: ['1', [Validators.required]],
      nickname: [null, [Validators.required]],
      game_code: [null]
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
    console.log(this.validateForm.value)

    if (this.validateForm.valid) {

      this.componentService.setGameAccount(this.validateForm.value).subscribe(res => {
        console.log(res);
        this.onSubmitAfter.emit(this.validateForm.value)

        if (res.code === 200) {
          this.validateForm.reset();
          this.message.success(res.message);
          this.handleCancel();
        } else {
          this.message.error(res.message);
        }


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
