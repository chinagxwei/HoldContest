import { Component, OnInit } from '@angular/core';
import {ServerManager} from "../../../../../../entity/user";
import {FormBuilder, FormControl, FormGroup, Validators} from "@angular/forms";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {ManagerService} from "../../../../../../services/system/manager.service";
import {RoleService} from "../../../../../../services/system/role.service";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {Paginate} from "../../../../../../entity/server-response";
import {Role} from "../../../../../../entity/system";

@Component({
    selector: 'app-manager',
    templateUrl: './manager.component.html',
    styleUrls: ['./manager.component.css']
})
export class ManagerComponent implements OnInit {


    currentData: Paginate<ServerManager> = new Paginate<ServerManager>();

    loading = true;

    listOfData: ServerManager[] = [];

    validateForm: FormGroup;

    isVisible = false;

    searchLoading = false;

    optionList: Role[] = [];

    constructor(
        private formBuilder: FormBuilder,
        private managerService: ManagerService,
        private roleService: RoleService,
        private message: NzMessageService,
        private modalService: NzModalService
    ) {
      this.validateForm = this.formBuilder.group({});
    }

    ngOnInit(): void {
        this.getItems();
    }

    submitForm(): void {
        if (this.validateForm.valid) {
            this.managerService.save(this.validateForm.value).subscribe(res => {
                console.log(res);
                if (res.code === 200) {
                    this.message.success(res.message);
                    this.handleCancel();
                    this.validateForm.reset();
                    this.getItems(this.currentData.current_page);
                }else{
                    this.message.error(JSON.stringify(res.message));
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

    updateConfirmValidator(): void {
        const {checkPassword} = this.validateForm.controls;
        /** wait for refresh value */
        Promise.resolve().then(() => checkPassword.updateValueAndValidity());
    }

    confirmationValidator = (control: FormControl): { [s: string]: boolean } => {
        if (!control.value) {
            return {required: true};
        } else if (control.value !== this.validateForm?.value?.password) {
            return {confirm: true, error: true};
        }
        return {};
    };

    getItems(page: number = 1) {
        this.loading = true;
        this.managerService.items<Paginate<ServerManager>>(page)
            .pipe(tap(_ => this.loading = false))
            .subscribe(res => {
                const {data} = res;
                if (data) {
                    this.currentData = data;
                    this.listOfData = data.data;
                }
            })
    }

    onDelete($event: ServerManager) {

        this.modalService.confirm({
            nzTitle: '删除提示',
            nzContent: '<b style="color: red;">是否删除该项数据!</b>',
            nzOkText: '确定',
            nzCancelText: '取消',
            nzOnOk: () => {
                this.managerService.delete($event.id).subscribe(res => {
                    this.getItems();
                });
            },
            nzOnCancel: () => {
                console.log('Cancel')
            }
        });
    }

    onQueryParamsChange(params: NzTableQueryParams): void {
        this.getItems(params.pageIndex)
    }

    handleOk() {
        this.submitForm();
    }

    handleCancel() {
        this.isVisible = false;
    }

    add() {
        this.validateForm = this.formBuilder.group({
            role_id: [null, [Validators.required]],
            mobile:[null, [Validators.required]],
            username: [null, [Validators.required]],
            password: [null, [Validators.required]],
            checkPassword: [null, [Validators.required, this.confirmationValidator]],
        });
        this.showModal();
    }

    showModal(): void {
        this.isVisible = true;
    }

    get isUpdate(): boolean {
        return this.validateForm.get('id')?.value > 0;
    }

    onSearch($event: string) {
        if($event){
            this.roleService.search($event).subscribe(({code, data}) => {
                console.log(data);
                this.optionList = data.data;
            })
        }
    }

    update(data: ServerManager) {
        if (data.role) {
            this.optionList = [data.role];
        }
        this.validateForm = this.formBuilder.group({
            id: [data.id],
            role_id: [data.role?.id],
            mobile:[data.mobile],
        });
        this.showModal()
    }

}
