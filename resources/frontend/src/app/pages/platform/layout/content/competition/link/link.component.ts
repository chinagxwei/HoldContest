import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {
  CompetitionGame,
  CompetitionRoom,
  CompetitionRoomLink,
  CompetitionRule
} from "../../../../../../entity/competition";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {CompetitionRoomLinkService} from "../../../../../../services/competition/competition-room-link.service";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {BehaviorSubject, debounceTime} from "rxjs";
import {CompetitionGameService} from "../../../../../../services/competition/competition-game.service";
import {CompetitionRuleService} from "../../../../../../services/competition/competition-rule.service";

@Component({
  selector: 'app-link',
  templateUrl: './link.component.html',
  styleUrls: ['./link.component.css']
})
export class LinkComponent implements OnInit {

  currentData: Paginate<CompetitionRoom> = new Paginate<CompetitionRoom>();

  loading = true;

  listOfData: CompetitionRoom[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  lastRoomCode = "";

  searchChange$ = new BehaviorSubject('');

  searchDataList: CompetitionRule[] = [];

  isSearchLoading = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: CompetitionRoomLinkService,
    private competitionRuleService: CompetitionRuleService,
  ) {
    this.validateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
    this.initQuickForm();
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
        let {data} = res;
        if (data) {
          this.currentData = data;
          this.listOfData = data.data;
        }
      })
  }

  showModal(): void {
    this.isVisible = true;
  }

  handleCancel() {
    this.isVisible = false;
  }

  add() {
    // this.initQuickForm();
    this.showModal();
  }

  getAvailableNumber(competition_rule_id: number | undefined) {
    this.lastRoomCode = ""
    this.componentService.lastRoomCode(competition_rule_id).subscribe(res => {
      console.log(res)
      if (res.code === 200){
        this.lastRoomCode = res.data.game_room_code;
      }
    })
  }

  initQuickForm(data?: CompetitionRule) {
    this.validateForm = this.formBuilder.group({
      competition_rule_id: [data?.id, [Validators.required]],
      urls: [null, [Validators.required]],
    });
    if (data) {
      this.getAvailableNumber(data.id)
    }
  }

  // onDelete($event: CompetitionRoom) {
  //   this.modalService.confirm({
  //     nzTitle: '删除提示',
  //     nzContent: '<b style="color: red;">是否删除该项数据!</b>',
  //     nzOkText: '确定',
  //     nzCancelText: '取消',
  //     nzOnOk: () => {
  //       this.componentService.delete($event.id).subscribe(res => {
  //         this.getItems(this.currentData.current_page);
  //       });
  //     },
  //     nzOnCancel: () => {
  //       console.log('Cancel')
  //     }
  //   });
  // }

  handleAdd() {
    if (this.validateForm.valid) {
      // console.log(this.validateForm.value);
      this.componentService.quickAdd(this.validateForm.value).subscribe(res => {
        console.log(res);
        if (res.code === 200) {
          this.message.success(res.message);
          this.handleCancel();
          this.validateForm.reset();
          this.getItems(this.currentData.current_page);
          // this.getAvailableNumber()
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

  onSearchSelect($event: number) {
    console.log($event)
    const select = this.searchDataList.find(v => v.id === $event);
    console.log(select)
    this.initQuickForm(select)
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
}
