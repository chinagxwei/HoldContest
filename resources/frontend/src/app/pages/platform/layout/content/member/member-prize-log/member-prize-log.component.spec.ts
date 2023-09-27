import { ComponentFixture, TestBed } from '@angular/core/testing';

import { MemberPrizeLogComponent } from './member-prize-log.component';

describe('MemberPrizeLogComponent', () => {
  let component: MemberPrizeLogComponent;
  let fixture: ComponentFixture<MemberPrizeLogComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ MemberPrizeLogComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(MemberPrizeLogComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
