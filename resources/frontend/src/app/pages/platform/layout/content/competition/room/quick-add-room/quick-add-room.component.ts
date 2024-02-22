import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {BehaviorSubject, debounceTime} from "rxjs";
import {CompetitionRoom, CompetitionRule} from "../../../../../../../entity/competition";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CompetitionRoomLinkService} from "../../../../../../../services/competition/competition-room-link.service";
import {CompetitionRuleService} from "../../../../../../../services/competition/competition-rule.service";
import {NzMessageService} from "ng-zorro-antd/message";
import {CompetitionRoomService} from "../../../../../../../services/competition/competition-room.service";

@Component({
  selector: 'app-quick-add-room',
  templateUrl: './quick-add-room.component.html',
  styleUrls: ['./quick-add-room.component.css']
})
export class QuickAddRoomComponent implements OnInit {

  validateForm: FormGroup;

  @Input()
  visible: boolean = false;

  @Output()
  visibleChange = new EventEmitter<boolean>();

  @Output()
  onSubmitAfter = new EventEmitter<any>();

  searchChange$ = new BehaviorSubject('');

  searchDataList: CompetitionRule[] = [];

  isSearchLoading = false;

  currentAvailableNumber: number = 0;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private componentService: CompetitionRoomService,
    private competitionRoomLinkService: CompetitionRoomLinkService,
    private competitionRuleService: CompetitionRuleService,
  ) {
    this.validateForm = this.formBuilder.group({
      competition_rule_id: [null, [Validators.required]],
      interval: ['2'],
      total: [1],
      start_second: [null],
      end_second: [null],
    });
  }

  ngOnInit(): void {
    this.initSearch()
  }

  handleCancel() {
    this.handleVisible(false);
  }

  handleVisible(type: boolean) {
    this.visible = type;
    this.visibleChange.emit(this.visible)
  }

  handleAdd() {
    if (this.validateForm.valid) {
      const postData = Object.assign({}, this.validateForm.value);
      console.log(postData)
      postData.end_second = postData.end_second / 1000;
      postData.start_second = postData.start_second / 1000;

      this.componentService.quickAdd(postData).subscribe(res => {
        this.onSubmitAfter.emit(postData);
        // console.log(res);
        if (res.code === 200) {
          this.message.success(res.message);

          this.validateForm.reset();
        } else {
          this.message.error(res.message);
        }
      });

      this.handleVisible(false);

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

  initSearch() {
    this.searchChange$
      .asObservable()
      .pipe(debounceTime(300))
      .subscribe((v) => {
        const rule = new CompetitionRule;
        rule.title = v;
        this.competitionRuleService
          .items(1, rule)
          .subscribe((res) => {
            this.searchDataList = res.data.data;
            this.isSearchLoading = false;
          })
      });
  }

  onSearch(value: string): void {
    this.isSearchLoading = true;
    this.searchChange$.next(value);
  }

  onSearchSelect($event: number) {
    console.log($event)
    const select = this.searchDataList.find(v => v.id === $event);
    console.log(select)
    this.updateQuickForm(select)
  }

  updateQuickForm(data: CompetitionRule | undefined) {
    if (!!data) {
      const stamp = new Date().setHours(0, 0, 0, 0);
      this.validateForm = this.formBuilder.group({
        competition_rule_id: [data?.id, [Validators.required]],
        interval: ['2'],
        total: [1],
        start_second: [Date.parse(new Date(stamp + data.default_start_second * 1000).toString())],
        end_second: [Date.parse(new Date(stamp + data.default_end_second * 1000).toString())],
      });
      this.getAvailableNumber(data.id)
    }
  }

  getAvailableNumber(competition_rule_id: number | undefined) {
    this.currentAvailableNumber = 0;
    this.competitionRoomLinkService.availableNumber(competition_rule_id).subscribe(res => {
      console.log(res)
      this.currentAvailableNumber = res.data.count;
    })
  }
}
