import { ComponentFixture, TestBed } from '@angular/core/testing';

import { UnitFormItemComponent } from './unit-form-item.component';

describe('UnitFormItemComponent', () => {
  let component: UnitFormItemComponent;
  let fixture: ComponentFixture<UnitFormItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ UnitFormItemComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(UnitFormItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
