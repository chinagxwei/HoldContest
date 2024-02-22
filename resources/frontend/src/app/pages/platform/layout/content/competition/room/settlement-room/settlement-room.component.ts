import {
  Component,
  EventEmitter,
  Input,
  OnChanges,
  OnInit,
  Output, SimpleChanges
} from '@angular/core';
import {FormBuilder, FormControl, FormGroup, FormRecord, NonNullableFormBuilder} from "@angular/forms";
import {Goods} from "../../../../../../../entity/goods";
import {CompetitionRoom} from "../../../../../../../entity/competition";
import {GoodsService} from "../../../../../../../services/goods/goods.service";
import {CompetitionRoomService} from "../../../../../../../services/competition/competition-room.service";
import {NzMessageService} from "ng-zorro-antd/message";
import {DomSanitizer, SafeUrl} from "@angular/platform-browser";

@Component({
  selector: 'app-settlement-room',
  templateUrl: './settlement-room.component.html',
  styleUrls: ['./settlement-room.component.css']
})
export class SettlementRoomComponent implements OnInit, OnChanges {

  @Input()
  currentRoom: CompetitionRoom = new CompetitionRoom()

  @Input()
  visible: boolean = false;

  @Output()
  visibleChange = new EventEmitter<boolean>();

  @Output()
  onSubmitAfter = new EventEmitter<{ room_id?: string, prizes: any }>();

  validateForm: FormRecord<FormControl<string>>;

  listOfControl: {
    id: number | undefined;
    member_id: string;
    win: number;
    controlInstance: string;
    value: number
  }[] = [];

  listOfOption: Goods[] = [];

  decodeUrl: any;

  constructor(
    private nonNullableFormBuilder: NonNullableFormBuilder,
    private message: NzMessageService,
    private goodsService: GoodsService,
    private componentService: CompetitionRoomService,
    private domSanitizer:DomSanitizer
  ) {
    this.validateForm = this.nonNullableFormBuilder.record({});
    this.goodsService.searchBind().subscribe(res => {
      // console.log(res);
      this.listOfOption = res.data.data;
    })
  }

  ngOnInit(): void {

  }


  handleCancel() {
    this.handleVisible(false);
  }

  handleVisible(type: boolean) {
    this.visible = type;
    this.visibleChange.emit(this.visible)
  }

  handleSettlementRoom() {
    console.log(this.validateForm.value);
    const {room_id,} = this.validateForm.value
    this.componentService.settlement(this.currentRoom.id, this.validateForm.value).subscribe(res => {
      this.onSubmitAfter.emit({room_id: this.currentRoom.id, prizes: this.validateForm.value})
      if (res.code === 200) {
        this.validateForm.reset();
        this.message.success(res.message);
        this.handleCancel();
      } else {
        this.message.error(res.message);
      }
    })
  }

  ngOnChanges(changes: SimpleChanges): void {
    if (this.currentRoom.participants) {
      this.listOfControl = this.currentRoom.participants.map(value => {
        return {
          id: value.id,
          member_id: value.member_id,
          win: value.win,
          controlInstance: `${value.id}`,
          value: 0
        }
      })

      let group = {};

      for (const listOfControlElement of this.listOfControl) {
        if (listOfControlElement.controlInstance) {
          // @ts-ignore
          group[listOfControlElement.controlInstance] = this.nonNullableFormBuilder.control(null);
          // @ts-ignore
          group[`value_${listOfControlElement.controlInstance}`] = this.nonNullableFormBuilder.control(0);
        }
      }
      this.validateForm = this.nonNullableFormBuilder.record(group);
    }

    this.decodeUrl = this.domSanitizer.bypassSecurityTrustResourceUrl(this.currentRoom.link);
  }


}
