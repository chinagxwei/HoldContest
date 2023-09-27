import {Component, OnInit} from '@angular/core';
import {Paginate} from "../../../../../../entity/server-response";
import {CompetitionGame, CompetitionRule} from "../../../../../../entity/competition";
import {FormBuilder, FormControl, FormGroup, FormRecord, NonNullableFormBuilder, Validators} from "@angular/forms";
import {AlertType, Mode} from "wangeditor-for-angular";
import {IDomEditor} from "@wangeditor/editor";
import {NzMessageService} from "ng-zorro-antd/message";
import {NzModalService} from "ng-zorro-antd/modal";
import {NzTableQueryParams} from "ng-zorro-antd/table";
import {tap} from "rxjs/operators";
import {CompetitionRuleService} from "../../../../../../services/competition/competition-rule.service";
import {BehaviorSubject, debounceTime, Observable, switchMap} from "rxjs";
import {CompetitionGameService} from "../../../../../../services/competition/competition-game.service";
import {GoodsService} from "../../../../../../services/goods/goods.service";
import {Goods} from "../../../../../../entity/goods";

@Component({
  selector: 'app-rule',
  templateUrl: './rule.component.html',
  styleUrls: ['./rule.component.css']
})
export class RuleComponent implements OnInit {


  currentData: Paginate<CompetitionRule> = new Paginate<CompetitionRule>();

  loading = true;

  listOfData: CompetitionRule[] = [];

  gameValidateForm: FormGroup;

  isGameVisible: boolean = false;

  valueHtml = "<p>hello</p>";

  mode: Mode = "default";

  editorConfig = {
    placeholder: "请输入内容...",
  };

  editorRef!: IDomEditor;

  isPrizeVisible: boolean = false;

  prizesValidateForm: FormRecord<FormControl<string>>;

  listOfControl: { goods_id: number | undefined; ranking: number; id: number; controlInstance: string }[] = [];

  listOfOption: Goods[] = [];

  currentRule?: CompetitionRule;

  constructor(
    private formBuilder: FormBuilder,
    private fb: NonNullableFormBuilder,
    private message: NzMessageService,
    private modalService: NzModalService,
    private componentService: CompetitionRuleService,
    private goodsService: GoodsService
  ) {
    this.prizesValidateForm = this.fb.record({});
    this.gameValidateForm = this.formBuilder.group({});
  }

  ngOnInit(): void {
    this.getItems();
    // this.initSearch();
    this.goodsService.searchBind().subscribe(res => {
      // console.log(res);
      this.listOfOption = res.data.data;
    })
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
          const stamp = new Date().setHours(0, 0, 0, 0);
          data.data.map(v => {
            v.default_start_second = Date.parse(new Date(stamp + v.default_start_second * 1000).toString());
            v.default_end_second = Date.parse(new Date(stamp + v.default_end_second * 1000).toString());
            return v
          })
          this.listOfData = data.data;
        }
      })
  }

  initForm() {
    this.gameValidateForm = this.formBuilder.group({
      title: [null, [Validators.required]],
      game_id: [null, [Validators.required]],
      team_game: [false],
      quick: [false],
      participants_price: [0],
      unit_id: [null, [Validators.required]],
      participants_number: [1],
      daily_participation_limit: [0],
      default_start_second: [new Date()],
      default_end_second: [new Date()],
      start_number: [null],
      rule: [null],
      description: [null],
      remark: [null],
      status: [null],
    });
  }

  update(data: CompetitionRule) {
    console.log(data)
    this.gameValidateForm = this.formBuilder.group({
      id: [data.id, [Validators.required]],
      title: [data.title, [Validators.required]],
      game_id: [data.game_id, [Validators.required]],
      team_game: [data.team_game],
      quick: [data.quick],
      participants_price: [data.participants_price / 100],
      unit_id: [data.unit_id],
      participants_number: [data.participants_number],
      daily_participation_limit: [data.daily_participation_limit],
      default_start_second: [new Date(data.default_start_second)],
      default_end_second: [new Date(data.default_end_second)],
      start_number: [data.start_number],
      rule: [data.rule],
      description: [data.description],
      remark: [data.remark],
      status: [data.status],
    });
    this.showModal()
  }

  onDelete($event: CompetitionRule) {

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
    // this.gameValidateForm?.reset();
    this.initForm();
    this.showModal();
  }

  showModal(): void {
    this.isGameVisible = true;
  }

  handleCancel() {
    this.isGameVisible = false;
  }

  handlePrizeCancel() {
    this.isPrizeVisible = false;
  }

  handleOk() {
    this.submitForm();
  }

  submitForm() {
    if (this.gameValidateForm?.valid) {
      const postData = Object.assign({}, this.gameValidateForm.value);
      postData.quick = postData.quick ? 1 : 0;
      postData.team_game = postData.team_game ? 1 : 0;
      postData.status = postData.status ? 1 : 0;
      postData.default_end_second = Date.parse(postData.default_end_second) / 1000;
      postData.default_start_second = Date.parse(postData.default_start_second) / 1000;
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

  customAlert({info, type}: { info: string; type: AlertType }) {
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

  customPaste({editor, event, callback}: any) {
    // 自定义插入内容
    // editor.insertText("xxx");
    // callback(false); // 返回 false ，阻止默认粘贴行为
    callback(true) // 返回 true ，继续默认的粘贴行为
  }

  showPrizeEdit(data: CompetitionRule) {
    this.currentRule = data;
    if (data.prizes) {
      this.listOfControl = data.prizes.map(value => {
        return {
          id: value.ranking,
          ranking: value.ranking,
          goods_id: value.goods_id,
          controlInstance: `${value.ranking}`
        }
      })

      let group = {};

      for (const listOfControlElement of this.listOfControl) {
        if (listOfControlElement.controlInstance) {
          if (listOfControlElement.goods_id) {
            // @ts-ignore
            group[listOfControlElement.controlInstance] = this.fb.control(listOfControlElement.goods_id);
          } else {
            // @ts-ignore
            group[listOfControlElement.controlInstance] = this.fb.control(null);
          }
        }
      }
      this.prizesValidateForm = this.fb.group(group);
    }
    // console.log(this.prizesValidateForm.value)
    this.isPrizeVisible = true;
  }

  handleSavePrize() {
    this.componentService
      .configPrize(this.currentRule?.id, this.prizesValidateForm.value)
      .subscribe(res => {
        this.isPrizeVisible = false;
        this.getItems()
      })
  }
}
