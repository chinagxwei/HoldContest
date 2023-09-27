import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LuckyDrawsItemComponent } from './lucky-draws-item.component';

describe('LuckyDrawsItemComponent', () => {
  let component: LuckyDrawsItemComponent;
  let fixture: ComponentFixture<LuckyDrawsItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LuckyDrawsItemComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(LuckyDrawsItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
