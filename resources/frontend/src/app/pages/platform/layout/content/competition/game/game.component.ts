import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {CompetitionGame} from "../../../../../../entity/competition";
import {CompetitionGameService} from "../../../../../../services/competition/competition-game.service";
import {IDomEditor} from "@wangeditor/editor";
import {AlertType, Mode} from "wangeditor-for-angular";

@Component({
  selector: 'app-game',
  templateUrl: './game.component.html',
  styleUrls: ['./game.component.css']
})
export class GameComponent implements OnInit {

  currentData: Paginate<CompetitionGame> = new Paginate<CompetitionGame>();

  loading = true;

  listOfData: CompetitionGame[] = [];


  // @ts-ignore
  gameValidateForm: FormGroup;

  isGameVisible: boolean = false;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: CompetitionGameService
  ) {
  }

  ngOnInit(): void {
    this.initForm();
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
          this.listOfData = data.data;
        }
      })
  }

  initForm() {
    this.gameValidateForm = this.formBuilder.group({
      game_name: [null, [Validators.required]],
      description: [null],
      remark: [null],
    });
  }

  update(data: CompetitionGame) {
    this.gameValidateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      game_name: [data.game_name, [Validators.required]],
      description: [data.description],
      remark: [data.remark],
    });
    this.showModal()
  }

  onDelete($event: CompetitionGame) {

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
    this.gameValidateForm?.reset();
    this.showModal();
  }

  showModal(): void {
    this.isGameVisible = true;
  }

  handleCancel() {
    this.isGameVisible = false;
  }

  handleOk() {
    this.submitForm();
  }

  submitForm() {
    if (this.gameValidateForm?.valid) {
      const postData = Object.assign({}, this.gameValidateForm.value);
      postData.quick = postData.quick ? 1 : 0;
      postData.team_game = postData.team_game ? 1 : 0;
      console.log(postData)
      this.componentService.save(postData).subscribe(res => {
        console.log(res);
        if (res.code === 200) {
          this.message.success(res.message);
          this.handleCancel();
          this.gameValidateForm.reset();
          this.getItems(this.currentData.current_page);
        }
      });
    } else {
      if (this.gameValidateForm?.controls) {
        Object.values(this.gameValidateForm.controls).forEach(control => {
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

}
