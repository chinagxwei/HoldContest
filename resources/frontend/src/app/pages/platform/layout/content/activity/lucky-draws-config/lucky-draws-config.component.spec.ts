import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LuckyDrawsConfigComponent } from './lucky-draws-config.component';

describe('LuckyDrawsConfigComponent', () => {
  let component: LuckyDrawsConfigComponent;
  let fixture: ComponentFixture<LuckyDrawsConfigComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LuckyDrawsConfigComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(LuckyDrawsConfigComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
