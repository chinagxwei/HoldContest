import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {SystemAgreement} from "../../../../../../entity/system";
import {AgreementService} from "../../../../../../services/system/agreement.service";
import {AlertType, Mode} from "wangeditor-for-angular";
import {IDomEditor} from "@wangeditor/editor";

@Component({
  selector: 'app-agreement',
  templateUrl: './agreement.component.html',
  styleUrls: ['./agreement.component.css']
})
export class AgreementComponent implements OnInit {

  currentData: Paginate<SystemAgreement> = new Paginate<SystemAgreement>();

  loading = true;

  listOfData: SystemAgreement[] = [];

  validateForm: FormGroup;

  isVisible: boolean = false;

  valueHtml = "<p>hello</p>";

  mode: Mode = "default";

  editorConfig = {
    placeholder: "请输入内容...",
  };

  editorRef!: IDomEditor;

  constructor(
    private formBuilder: FormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: AgreementService) {
    this.validateForm = this.formBuilder.group({});
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
      title: [null, [Validators.required]],
      content: [null, [Validators.required]],
      show: [null],
    });
  }

  update(data: SystemAgreement) {
    this.validateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      content: [data.content, [Validators.required]],
      show: [data.show],
    });
    this.showModal()
  }

  onDelete($event: SystemAgreement) {

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


  handleCreated(editor: IDomEditor) {
    console.log("created", editor);
    this.editorRef = editor;
  }

  handleChange(editor: IDomEditor) {
    console.log("change:", editor);
  }

  handleValueChange(value: string) {
    console.log("value change:", value);
  }

  handleFocus(editor: IDomEditor) {
    console.log("focus", editor);
  }
  handleBlur(editor: IDomEditor) {
    console.log("blur", editor);
  }

  customAlert({ info, type }: { info: string; type: AlertType }) {
    alert(`【customAlert】${type} - ${info}`);
  }

  handleDestroyed(editor: IDomEditor) {
    console.log("destroyed", editor);
  }

  insertText() {
    if (this.editorRef == null) return;
    this.editorRef.insertText("hello world");
  }

  printHtml() {
    if (this.editorRef == null) return;
    console.log(this.editorRef.getHtml());
  }

  customPaste({ editor, event, callback }: any) {
    // 自定义插入内容
    // editor.insertText("xxx");
    // callback(false); // 返回 false ，阻止默认粘贴行为
    callback(true) // 返回 true ，继续默认的粘贴行为
  }
}
