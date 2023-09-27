import { Component, OnInit } from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {FormBuilder, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {CompetitionRoom} from "../../../../../../entity/competition";
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

    // @ts-ignore
    validateForm: FormGroup;

    isVisible: boolean = false;

    constructor(
        private formBuilder: FormBuilder,
        private message: NzMessageService,
        private modalService: NzModalService,
        private componentService: CompetitionRoomService
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
        this.validateForm = this.formBuilder.group({
            game_id: [null, [Validators.required]],
            game_room_name: [null, [Validators.required]],
            quick: [null],
            complete: [null],
            game_room_qrcode: [null, [Validators.required]],
            interval: [5],
        });
    }

    update(data: CompetitionRoom) {
        this.validateForm = this.formBuilder.group({
            id: [data.id, [Validators.required]],
            game_id: [data.game_id, [Validators.required]],
            game_room_name: [data.game_room_name, [Validators.required]],
            quick: [data.quick],
            complete: [data.complete],
            game_room_qrcode: [data.game_room_qrcode, [Validators.required]],
            interval: [data.interval],
        });
        this.showModal()
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

    add() {
        this.validateForm.reset();
        this.showModal();
    }

    showModal(): void {
        this.isVisible = true;
    }

    handleCancel() {
        this.isVisible = false;
    }

    handleOk() {
        this.submitForm();
    }

    submitForm() {
        if (this.validateForm.valid) {
            this.componentService.save(this.validateForm.value).subscribe(res => {
                console.log(res);
                if (res.code === 200) {
                    this.message.success(res.message);
                    this.handleCancel();
                    this.validateForm.reset();
                    this.getItems(this.currentData.current_page);
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
}
