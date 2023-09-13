import { Component, OnInit } from '@angular/core';
import {ActionLog} from "../../../../../../entity/user";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {ManagerService} from "../../../../../../services/system/manager.service";
import {Paginate} from "../../../../../../entity/server-response";

@Component({
  selector: 'app-action-log',
  templateUrl: './action-log.component.html',
  styleUrls: ['./action-log.component.css']
})
export class ActionLogComponent implements OnInit {


  currentData: Paginate<ActionLog> = new Paginate<ActionLog>();

  loading = true;

  listOfData: ActionLog[] = [];

  constructor(
    private managerService: ManagerService,
  ) { }

  ngOnInit(): void {
    this.getItems();
  }

  onQueryParamsChange($event: NzTableQueryParams) {
    this.getItems($event.pageIndex);
  }

  private getItems(page: number = 1) {
    this.loading = true;
    this.managerService.actionLog(page)
      .pipe(tap(_ => this.loading = false))
      .subscribe(res => {
        const {data} = res;
        if (data) {
          this.currentData = data;
          this.listOfData = data.data;
        }
      })
  }
}
