import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {CompetitionRoom, CompetitionRule} from "../../../../../../entity/competition";
import {CompetitionRoomService} from "../../../../../../services/competition/competition-room.service";


@Component({
  selector: 'app-room',
  templateUrl: './room.component.html',
  styleUrls: ['./room.component.css']
})
export class RoomComponent implements OnInit {

  currentData: Paginate<CompetitionRoom> = new Paginate<CompetitionRoom>();

  loading = true;

  listOfData: CompetitionRoom[] = [];

  isVisible: boolean = false;

  searchDataList: CompetitionRule[] = [];

  isPrizeVisible: boolean = false;

  currentRoom: CompetitionRoom = new CompetitionRoom();

  isJoinVisible: boolean = false;

  constructor(
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: CompetitionRoomService,
  ) {
  }

  ngOnInit(): void {
    this.getItems();
  }

  get currentTime() {
    return new Date().getMilliseconds() / 1000;
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
          const stamp = new Date().setHours(0, 0, 0, 0);
          data.data.map(v => {
            v.ready_at = v.ready_at * 1000;
            v.started_at = v.started_at * 1000;
            v.ended_at = v.ended_at * 1000;
            // @ts-ignore
            v.competition_rule.default_start_second = Date.parse(new Date(stamp + v.competition_rule.default_start_second * 1000).toString());
            // @ts-ignore
            v.competition_rule.default_end_second = Date.parse(new Date(stamp + v.competition_rule.default_end_second * 1000).toString());
            return v
          })
          this.listOfData = data.data;
        }
      })
  }

  onDelete($event: CompetitionRoom) {

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

  handleRefresh(){
    this.getItems(this.currentData.current_page);
  }

  add() {
    this.isVisible = true;
  }

  onJoin(data: CompetitionRoom) {
    this.currentRoom = data;
    this.isJoinVisible = true;
  }

  onShowJoinMember(data: CompetitionRoom) {
    this.currentRoom = data;
    this.isPrizeVisible = true;
  }

}
