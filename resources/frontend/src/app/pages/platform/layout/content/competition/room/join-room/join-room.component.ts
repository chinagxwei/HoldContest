import {Component, EventEmitter, Input, OnChanges, OnInit, Output, SimpleChanges} from '@angular/core';
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CompetitionRoom} from "../../../../../../../entity/competition";
import {CompetitionRoomService} from "../../../../../../../services/competition/competition-room.service";
import {NzMessageService} from "ng-zorro-antd/message";

@Component({
  selector: 'app-join-room',
  templateUrl: './join-room.component.html',
  styleUrls: ['./join-room.component.css']
})
export class JoinRoomComponent implements OnInit, OnChanges {

  @Input()
  currentRoom: CompetitionRoom = new CompetitionRoom()

  @Input()
  visible: boolean = false;

  @Output()
  visibleChange = new EventEmitter<boolean>();

  @Output()
  onSubmitAfter = new EventEmitter<{ id?: string, member_id: string }>();

  validateForm: FormGroup;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private componentService: CompetitionRoomService,
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.validateForm = this.formBuilder.group({
      id: [this.currentRoom.id, [Validators.required]],
      member_id: [null, [Validators.required]],
    });
  }

  handleCancel() {
    this.handleVisible(false);
  }

  handleVisible(type: boolean) {
    this.visible = type;
    this.visibleChange.emit(this.visible)
  }

  handleJoin() {
    const {id, member_id} = this.validateForm.value;
    this.componentService.join(id, member_id).subscribe(res => {
      this.onSubmitAfter.emit({id: this.currentRoom.id, member_id});
      if (res.code === 200) {
        this.validateForm.reset();
        this.message.success(res.message);
        this.handleCancel();
      } else {
        this.message.error(res.message);
      }
    })

  }


}
