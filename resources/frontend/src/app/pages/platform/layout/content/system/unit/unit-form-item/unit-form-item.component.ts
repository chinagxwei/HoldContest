import {Component, Input, OnChanges, OnInit, SimpleChanges} from '@angular/core';
import {BehaviorSubject, debounceTime} from "rxjs";
import {Unit} from "../../../../../../../entity/system";
import {UnitService} from "../../../../../../../services/system/unit.service";
import {FormGroup, Validators} from "@angular/forms";

@Component({
  selector: 'app-unit-form-item',
  templateUrl: './unit-form-item.component.html',
  styleUrls: ['./unit-form-item.component.css']
})
export class UnitFormItemComponent implements OnInit, OnChanges {


  @Input()
  formGroup!: FormGroup;

  @Input()
  controlName: string = 'unit_id';

  searchChange$ = new BehaviorSubject('');

  isSearchLoading = false;

  searchDataList: Unit[] = [];

  unit_id: number = 0;

  constructor(private unitService: UnitService) {
  }

  ngOnInit(): void {
    this.initSearch();
  }

  ngOnChanges(changes: SimpleChanges): void {
    this.unit_id = this.formGroup.controls[this.controlName].value
  }

  onSearch(value: string) {
    this.isSearchLoading = true;
    this.searchChange$.next(value);
  }

  initSearch() {
    this.searchChange$.asObservable()
      .pipe(debounceTime(300))
      .subscribe((v) => {
        this.unitService
          .items(1, {title: v})
          .subscribe((res) => {
            this.searchDataList = res.data.data;
            this.isSearchLoading = false;
          })
      });
  }

  onChange($event: number) {
    this.formGroup.controls[this.controlName].setValue($event)
  }


}
